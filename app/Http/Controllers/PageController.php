<?php

namespace App\Http\Controllers;

use App\Highlights;
use App\PlayerHighlights;
use App\Teams;
use App\Games;
use App\Players;
use Carbon\Carbon;

class PageController extends Controller
{
    //
    public function index()
    {

        // Get id's of teams with recent highlights and order by count
        $teamIds = Highlights::select('team_id', \DB::raw('COUNT(id) as total'))
            ->where('created_at', '>', Carbon::now()->subHours(36))
            ->groupBy('team_id')
            ->orderByDesc('total')
            ->take(10)
            ->pluck('team_id');

        if(!$teamIds) {
            $teamIds = Highlights::where('created_at', '>', Carbon::now()->subHours(72))
                ->take(10)
                ->pluck('team_id');
        }

        // Get Teams
        $teamsWithHighlights = Teams::whereIn('id', $teamIds)->get();
        $teamsWithHighlights->load(['league']);
        $popularTeams = [];
        foreach ($teamsWithHighlights as $team) {
            $popularTeams[] = [
                'name' => $team->nickname,
                'url' => url('/' . $team->league->name . '/' . str_slug($team->nickname)),
                'iconHtml' => $team->league->icon()
            ];
        }

        // Recent Games
        $gameIds = Highlights::select('game_id', \DB::raw('MAX(created_at) as most_recent'))
            ->groupBy('game_id')
            ->orderByDesc('most_recent')
            ->take(10)
            ->pluck('game_id');

        $games = Games::whereIn('id', $gameIds)->get();
        $games->load(['homeTeam', 'awayTeam', 'league']);

        $recentGames = [];
        foreach ($games as $game) {
            $recentGames[] = [
                'homeTeam' => [
                    'nickname' => $game->homeTeam->nickname,
                    'score' => $game->home_score,
                ],
                'awayTeam' => [
                    'nickname' => $game->awayTeam->nickname,
                    'score' => $game->away_score,
                ],
                'date' =>  $game->start_date->format('n/j'),
                'iconHtml' => $game->league->icon(),
                'url' => url('/' . $game->league->name . '/' . str_slug($game->homeTeam->nickname) . '/' . $game->url_segment)
            ];
        }

        // Get id's of players with recent highlights and order by count
        $playerIds = PlayerHighlights::select('player_id', \DB::raw('COUNT(tweet_logs_id) as total'))
            ->where('created_at', '>', Carbon::now()->subHours(36))
            ->groupBy('player_id')
            ->orderByDesc('total')
            ->take(10)
            ->pluck('player_id')
            ->toArray();

        // Get Teams
        $playersWithHighlights = Players::whereIn('id', $playerIds)->get();
        $playersWithHighlights->load(['team.league']);

        $popularPlayers = [];
        foreach ($playersWithHighlights as $player) {
            $popularPlayers[] = [
                'name' => $player->first_name . ' ' . $player->last_name,
                'url' => $player->url(),
                'iconHtml' => $player->team->league->icon()
            ];
        }

        $data = [
            'recentGames' => $recentGames,
            'popularTeams' => $popularTeams,
            'popularPlayers' => $popularPlayers
        ];

        return view('welcome', $data);
    }
}

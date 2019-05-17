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
        $teamIds = Highlights::select('team_id', \DB::raw('count(*) as total'))
            ->where('created_at', '>', Carbon::now()->subHours(36))
            ->groupBy('team_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->toArray();

        // Get Teams
        $teamsWithHighlights = Teams::whereIn('id', $teamIds)->get();
        $teamsWithHighlights->load(['league']);
        $popularTeams = [];
        foreach ($teamsWithHighlights as $team) {
            $popularTeams[] = [
                'name' => $team->nickname,
                'url' => url('/' . $team->league->name . '/' . str_slug($team->nickname))
            ];
        }

        // Recent Games
        $games = Games::orderBy('start_date', 'DESC')
            ->take(5)->get();
        $games->load(['homeTeam', 'awayTeam', 'league']);

        $recentGames = [];
        foreach ($games as $game) {
            $recentGames[] = [
                'name' => $game->homeTeam->nickname . ' vs ' . $game->awayTeam->nickname . ' - ' . $game->start_date->format('M j y'),
                'url' => url('/' . $game->league->name . '/' . str_slug($game->homeTeam->nickname) . '/' . $game->url_segment)
            ];
        }

        // Get id's of players with recent highlights and order by count
        $playerIds = PlayerHighlights::select('player_id', \DB::raw('count(*) as total'))
            ->where('created_at', '>', Carbon::now()->subHours(36))
            ->groupBy('player_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->toArray();

        // Get Teams
        $playersWithHighlights = Players::whereIn('id', $playerIds)->get();

        $popularPlayers = [];
        foreach ($playersWithHighlights as $player) {
            $popularPlayers[] = [
                'name' => $player->first_name . ' ' . $player->last_name,
                'url' => $player->url()
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

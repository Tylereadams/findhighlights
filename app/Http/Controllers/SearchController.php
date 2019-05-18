<?php

namespace App\Http\Controllers;

use App\Games;
use App\Highlights;
use App\Leagues;
use Illuminate\Http\Request;
use App\Teams;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Players;
use Carbon\Carbon;

class SearchController extends Controller
{
    //

    public function index($leagueName, $teamName = null, $gameUrlSegment = null)
    {
        $selectedLeague = Leagues::where('name', $leagueName)->orderBy('name')->firstOrFail();
        $teams = Teams::where('league_id', $selectedLeague->id)->orderBy('nickname')->get();

        $leagues = Leagues::all();
        foreach($leagues as $league) {
            $leagueOptions[] = [
                'url' => url('/'.$league->name),
                'label' => strtoupper($league->name),
                'selected' => $league->id == $selectedLeague->id ? true : false,
            ];
        }

        $breadcrumbs[] = [
                'url' => url('/'.$selectedLeague->name),
                'name' => strtoupper($selectedLeague->name),
                'options' => $leagueOptions
        ];

        $highlightsQuery = Highlights::whereHas('team', function($q) use($selectedLeague) {
            $q->where('league_id', $selectedLeague->id);
        });

        if($teamName) {
            $selectedTeam = Teams::where('league_id', $selectedLeague->id)
                ->where('nickname', str_replace('-', ' ', $teamName))
                ->firstOrFail();

            $games = Games::where('home_team_id', $selectedTeam->id)
                ->orWhere('away_team_id', $selectedTeam->id)
                ->orderBy('start_date', 'DESC')
                ->get();
            $games->load(['homeTeam', 'awayTeam', 'league']);

            foreach($teams as $team) {
                $teamOptions[] = [
                    'url' => url('/'.$selectedLeague->name.'/'.str_slug($team->nickname)),
                    'label' => $team->nickname,
                    'selected' => $team->id == $selectedTeam->id ? true : false
                ];
            }

            $breadcrumbs[] = [
                'url' => url('/'.$selectedLeague->name.'/'.str_slug($selectedTeam->nickname)),
                'name' => ucwords($selectedTeam->nickname),
                'options' => $teamOptions
            ];

            $highlightsQuery->where('team_id', $selectedTeam->id);
        }

        if($gameUrlSegment) {
            $selectedGame = $games->where('url_segment',$gameUrlSegment)->first();

            foreach($games as $game) {
                $gameOptions[] = [
                    'url' => url('/'.$selectedLeague->name.'/'.str_slug($selectedTeam->nickname).'/'.$game->url_segment),
                    'label' => $game->homeTeam->nickname.' vs '.$game->awayTeam->nickname.' - '.$game->start_date->format('M j y'),
                    'selected' => $game->id == $selectedGame->id ? true : false
                ];
            }

            $breadcrumbs[] = [
                'url' => url('/'.$selectedLeague->name.'/'.str_slug($selectedTeam->nickname).'/'.$selectedGame->url_segment),
                'name' => $selectedGame->homeTeam->nickname.' vs '.$selectedGame->awayTeam->nickname,
                'options' => $gameOptions
            ];

            $highlightsQuery->whereHas('game', function($q) use($selectedGame){
                $q->where('url_segment', $selectedGame->url_segment);
            });
        }

        $highlightsPaginated = $highlightsQuery->orderBy('created_at', 'DESC')->paginate(12);
        $highlightsPaginated->load(['game.league', 'game.awayTeam', 'game.homeTeam', 'team.league', 'players']);

        $groupedHighlights = $highlightsPaginated->groupBy(function($highlight){
            return $highlight->game->homeTeam->nickname.' vs '.$highlight->game->awayTeam->nickname;
        })->groupBy(function($gameHighlights){
            return $gameHighlights->first()->game->start_date->format('n/j');
        });

        $data = [
            'groupedHighlights' => $groupedHighlights,
            'breadcrumbs' => $breadcrumbs,
            'highlightsPaginated' => $highlightsPaginated
        ];

        return view('highlights', $data);
    }

    /**
     * Returns autocomplete data for search box
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request) {

        $textToSearch = $request->query('term');

        $results = DB::select(
            DB::raw('
           SELECT search.id, search.text as label, search.category from (
                      (select id, CONCAT(first_name, " ", last_name) as "text", "Players" as "category" from players
                          WHERE CONCAT(first_name, " ", last_name) LIKE "%'.$textToSearch.'%" LIMIT 10)
                    UNION
                        (select id, CONCAT(location, " ", nickname) as "text", "Teams" as "category" from teams
                          WHERE CONCAT(location, " ", nickname) LIKE "%'.$textToSearch.'%" LIMIT 10)
                    UNION
                        (select id, name as "text", "Leagues" as "category" from leagues
                          WHERE name LIKE "%'.$textToSearch.'%")
                    UNION
                       (select games.id, CONCAT(homeTeam.nickname, " vs ", awayTeam.nickname, " ", DATE_FORMAT(games.start_date, "%e/%d/%Y")) as text, "Games" as "category" from games
                            JOIN teams as homeTeam ON homeTeam.id = games.home_team_id
                            JOIN teams as awayTeam ON awayTeam.id = games.away_team_id
                          WHERE CONCAT(homeTeam.nickname, " vs ", awayTeam.nickname, " ", DATE_FORMAT(games.start_date, "%e/%d/%Y")) LIKE "%'.$textToSearch.'%" order by start_date DESC LIMIT 10)
            ) as search
        '));

        foreach($results as $result) {
            $categories[$result->category][] = $result->id;
        }

        $models = new Collection();
        foreach($categories as $key => $ids) {
            switch($key) {
                case 'Players':
                    $players = Players::whereHas('highlights')->whereHas('team')->whereIn('id', $ids)->get();
                    $players->load('team.league');
                    $players->map(function($player)use($models, $results){
                       $models->push([
                           'url' => $player->url(),
                           'label' => $player->getFullName(),
                           'icon' => $player->team->league->icon(),
                           'category' => 'Players'
                       ]);
                    });
                    break;
                case 'Games':
                    $games = Games::whereIn('id', $ids)->whereHas('highlights')->orderBy('start_date', 'DESC')->get();
                    $games->load(['homeTeam', 'awayTeam', 'league']);
                    $games->map(function($game)use($models){
                        $models->push([
                            'url' => $game->url(),
                            'label' => $game->homeTeam->nickname.' vs '.$game->awayTeam->nickname.' ('.$game->start_date->format('n/j/y').')',
                            'icon' => $game->league->icon(),
                            'category' => 'Games'
                        ]);
                    });
                    break;
                case 'Teams':
                    $teams = Teams::whereIn('id', $ids)->get();
                    $teams->load(['league']);
                    $teams->map(function($team)use($models){
                        $models->push([
                            'url' => $team->url(),
                            'label' => $team->nickname,
                            'icon' => $team->league->icon(),
                            'category' => 'Teams'
                        ]);
                    });
                    break;
                case 'Leagues':
                    $leagues = Leagues::whereIn('id', $ids)->get();
                    $leagues->map(function($league)use($models){
                        $models->push([
                            'url' => $league->url(),
                            'label' => $league->name,
                            'category' => 'Leagues'
                        ]);
                    });
                    break;
            }
        }

        return response()->json($models->toArray());
    }

    public function player($urlSegment)
    {
        $player = Players::where('url_segment', $urlSegment)->firstOrFail();


        $highlightsPaginated = $player->highlights()->whereHas('game')->orderBy('created_at', 'DESC')->paginate();

        $groupedHighlights = $highlightsPaginated->groupBy(function($highlight){
            return $highlight->game->homeTeam->nickname.' vs '.$highlight->game->awayTeam->nickname;
        })->groupBy(function($gameHighlights){
            return $gameHighlights->first()->game->start_date->format('n/j');
        });

        $data = [
            'highlightsPaginated' => $highlightsPaginated,
            'groupedHighlights' => $groupedHighlights,
            'breadcrumbs' => [
                [
                    'url' => $player->team->league->url(),
                    'name' => strtoupper($player->team->league->name)
                ],
                [
                    'url' => $player->team->url(),
                    'name' => $player->team->nickname
                ],
                [
                    'url' => $player->url(),
                    'name' => $player->getFullName()
                ]
            ]
        ];

        return view('highlights', $data);
    }
}
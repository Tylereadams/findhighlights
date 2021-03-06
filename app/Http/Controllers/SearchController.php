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
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    //

    public function index($leagueName, $teamName = null, $gameUrlSegment = null)
    {
        $selectedLeague = Leagues::where('name', $leagueName)->orderBy('name')->firstOrFail();

        $leagues = Leagues::all();
        foreach($leagues as $league) {
            $leagueOptions[] = [
                'url' => url('/'.$league->name),
                'label' => strtoupper($league->name),
            ];
        }

        $breadcrumbs[] = [
                'url' => url('/'.$selectedLeague->name),
                'name' => strtoupper($selectedLeague->name),
        ];

        $highlightsQuery = Highlights::whereHas('team', function($q) use($selectedLeague) {
            $q->where('league_id', $selectedLeague->id);
        });

        if($teamName) {
            $selectedTeam = Teams::where('league_id', $selectedLeague->id)
                ->where('nickname', str_replace('-', ' ', $teamName))
                ->firstOrFail();

            $breadcrumbs[] = [
                'url' => url('/'.$selectedLeague->name.'/'.str_slug($selectedTeam->nickname)),
                'name' => ucwords($selectedTeam->nickname),
            ];

            $highlightsQuery->wherehas('game', function($q) use($selectedTeam) {
                $q->where('home_team_id', $selectedTeam->id);
                $q->orWhere('away_team_id', $selectedTeam->id);
            });
        }

        if($gameUrlSegment) {
            $selectedGame = Games::where('url_segment', $gameUrlSegment)->firstOrFail();

            $breadcrumbs[] = [
                'url' => url('/'.$selectedLeague->name.'/'.str_slug($selectedTeam->nickname).'/'.$selectedGame->url_segment),
                'name' => $selectedGame->homeTeam->nickname.' vs '.$selectedGame->awayTeam->nickname,
            ];

            $highlightsQuery->where('game_id', $selectedGame->id);
        }

        $highlightsPaginated = $highlightsQuery->orderBy('created_at', 'DESC')->paginate(24);
        $highlightsPaginated->load(['game.league', 'game.awayTeam', 'game.homeTeam', 'team.league', 'players']);

        $groupedHighlights = $highlightsPaginated->groupBy(function($highlight){
            return $highlight->game->homeTeam->nickname.' vs '.$highlight->game->awayTeam->nickname;
        })->groupBy(function($gameHighlights){
            return $gameHighlights->first()->game->start_date->format('n/j');
        });

        $data = [
            'groupedHighlights' => $groupedHighlights,
            'breadcrumbs' => $breadcrumbs,
            'activeTab' => strtolower($selectedLeague->name),
            'highlightsPaginated' => $highlightsPaginated,
            'metaTags' => [
                'title' => isset($selectedGame) ? $selectedGame->getTitle() : strtoupper($selectedLeague->name),
                'description' => 'View all highlights',
                'imageUrl' => isset($selectedGame) ? $selectedGame->imageUrl() : '',
                'url' => end($breadcrumbs)['url'],
            ]
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

        $results = Cache::remember($textToSearch.'-text-to-search', 120, function () use($textToSearch) {
                $results =  DB::select(
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

                return $results;
        });

        $categories = [];
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
            'activeTab' => strtolower($player->team->league->name),
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
            ],
            'metaTags' => [
                'description' => 'View all '.$player->first_name.' '. $player->last_name.' highlights',
                'url' => $player->url(),
            ]
        ];

        return view('highlights', $data);
    }
}
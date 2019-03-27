<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leagues;
use App\Teams;
use App\Games;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    //
    public function index()
    {
        $searchOptions = Cache::remember('autocomplete', 1, function () {
            $leagues = Leagues::all();
            foreach ($leagues as $league) {
                $searchOptions['leagues'][] = [
                    'name' => strtoupper($league->name),
                    'url' => url('/' . $league->name),
                    'category' => 'Leagues'
                ];
            }

            $teams = Teams::orderBy('nickname')->get();
            $teams->load(['players', 'league']);

            foreach ($teams as $team) {
                $searchOptions['teams'][] = [
                    'name' => $team->nickname,
                    'url' => url('/' . $team->league->name . '/' . str_slug($team->nickname)),
                    'category' => 'Teams'
                ];
            }

            $games = Games::orderBy('start_date', 'DESC')
                ->take(100)->get();
            $games->load(['homeTeam', 'awayTeam', 'league']);

            foreach ($games as $game) {
                $searchOptions['games'][] = [
                    'name' => $game->homeTeam->nickname . ' vs ' . $game->awayTeam->nickname . ' - ' . $game->start_date->format('M j y'),
                    'url' => url('/' . $game->league->name . '/' . str_slug($game->homeTeam->nickname) . '/' . $game->url_segment),
                    'category' => 'Games'
                ];
            }

            return $searchOptions;
        });

        $data['searchOptions'] = $searchOptions;

        return view('welcome', $data);
    }
}

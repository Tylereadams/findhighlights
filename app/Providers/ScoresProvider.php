<?php

namespace App\Providers;

use App\Games;
use App\Leagues;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class ScoresProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function getLeagueScores(Leagues $league, Carbon $date)
    {
        $games = Games::where('league_id', $league->id)
            ->where('start_date', 'LIKE', '%'.$date->format('Y-m-d').'%')
            ->get();
        $games->load(['homeTeam', 'awayTeam', 'highlights']);

        $data = [];
        foreach($games as $game) {
            $data[] = [
                'homeTeam' => [
                    'name' => $game->homeTeam->nickname,
                    'score' => $game->home_score,
                    'hexColors' => $game->homeTeam->colors->pluck('hex')->toArray()
                ],
                'awayTeam' => [
                    'name' => $game->awayTeam->nickname,
                    'score' => $game->away_score,
                    'hexColors' => $game->awayTeam->colors->pluck('hex')->toArray()
                ],
                'highlightCount' => $game->highlights->count()
            ];
        }

        return $data;
    }
}

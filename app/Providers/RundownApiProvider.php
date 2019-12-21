<?php

namespace App\Providers;

use App\Games;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use App\Leagues;
use Illuminate\Support\Facades\Config;
use App\Providers\TeamMapperProvider;
use App\Teams;

class RundownApiProvider extends ServiceProvider
{
    private $leagueMapping = [
        Leagues::NBA_ID => 4,
        Leagues::MLB_ID => 3,
        Leagues::NFL_ID => 2,
        Leagues::NHL_ID => 6
    ];

    private $statusMapping = [
        'STATUS_SCHEDULED' => Games::UPCOMING,
        'STATUS_IN_PROGRESS' => Games::IN_PROGRESS,
        'STATUS_FINAL' => Games::ENDED,
        'STATUS_POSTPONED' => Games::POSTPONED,
        'STATUS_HALFTIME' => null
    ];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://therundown-therundown-v1.p.rapidapi.com/',
            'headers' => [
                'x-rapidapi-key'     => Config::get('services.rapidapi.key'),
                'x-rapidapi-host'      => 'therundown-therundown-v1.p.rapidapi.com',
            ],
        ]);

        $this->teamMapper = new TeamMapperProvider();
    }

    public function getGamesByDate(Carbon $date, Leagues $league)
    {
        //map league
        $rundownLeagueId = $this->leagueMapping[$league->id];

//        $results = Cache::remember('game-data-'.$date->format('YYYY-mm-dd').'-'.$rundownLeagueId, 60 * 60 * 12, function()use($rundownLeagueId, $date){
            $res = $this->client->request('GET', 'sports/'.$rundownLeagueId.'/events/'.$date->toIso8601String(), [
                'query' => [
                    'include' => 'all_periods',
                    'include' => 'scores',
                    'offset' => 240
                ]
            ]);
            $results = json_decode($res->getBody());

//            return $results;
//        });

        $games = [];
        foreach($results->events as $game) {
            $games[] = $this->mapGameData($game, $league);
        }

        return $games;
    }

    /**
     * @param $games (array)
     * @param $league (str)
     * @return array|string
     */
    private function mapGameData($game, Leagues $league)
    {
        // Find team id's by name and league.
        $homeTeam = $game->teams_normalized[0]->is_home ? $game->teams_normalized[0] : $game->teams_normalized[1];
        $awayTeam = $game->teams_normalized[1]->is_home ? $game->teams_normalized[0] : $game->teams_normalized[1];

        // Map teams
        $teamMapper = new TeamMapperProvider();
        $mappedHomeTeam = $teamMapper->mapteam($homeTeam->mascot, $league);
        $mappedAwayTeam = $teamMapper->mapteam($awayTeam->mascot, $league);

        // Bovada odds
        $oddsMakers = [2, 1, 3, 4, 5, 6 ,7, 8, 9];
        foreach($oddsMakers as $oddsMaker) {
            if(isset($game->lines->{$oddsMaker})){
                $odds = $game->lines->{$oddsMaker};
                break;
            }
        }

        $gameData = [
            'home_team_id'  => (int) $mappedHomeTeam->id,
            'away_team_id'  => (int) $mappedAwayTeam->id,
            'league_id'     => $league->id,
            'home_score'    => $game->score->event_status == 'STATUS_SCHEDULED' ? null : $game->score->score_home,
            'away_score'    => $game->score->event_status == 'STATUS_SCHEDULED' ? null : $game->score->score_away,
            'home_spread' => isset($odds->spread->point_spread_home) ? $odds->spread->point_spread_home : null,
            'away_spread' => isset($odds->spread->point_spread_away) ? $odds->spread->point_spread_away : null,
            'broadcast'     => $game->score->broadcast,
            'period'        => $game->score->game_period > 0 ? $game->score->game_period : NULL, // Returns 0 sometimes, show NULL instead
            'status'     => $this->statusMapping[$game->score->event_status] ? $this->statusMapping[$game->score->event_status] : null,
//            'ended_at'      => $game->score->event_status == 'STATUS_FINAL' ? Carbon::parse($game->event_date, 'UTC')->timezone('America/New_York')->addHours(4)->format('Y-m-d H:i:s') : null,
            'start_date'    => Carbon::parse($game->event_date, 'UTC')->timezone('America/New_York')->format('Y-m-d H:i:s')
        ];

        return $gameData;
    }

//    private function mapTeamData($team)
//    {
//        $twitter = Twitter::getUsersSearch(['q' => $team->location.' '.$team->nickname]);
//
//        return [
//            'nickname' => $team->mascot,
////            'hashtag' => $team->hashtag,
//            'location' => $team->name,
////            'latitude' => $team->latitude,
////            'longitude' => $team->longitude,
////            'league_id' => $league->id,
////            'colors' => $team->colors,
////            'slug' => $team->slug,
//            'twitter' => $twitter[0]->screen_name
//        ];
//    }

}

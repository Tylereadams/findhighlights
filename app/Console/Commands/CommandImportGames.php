<?php

namespace App\Console\Commands;

use App\Games;
use App\Leagues;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Providers\RundownApiProvider;
use Carbon\CarbonPeriod;

class CommandImportGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importer:import-games {date=now}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import games into DB by given date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $leagues = Leagues::all();
        $date = Carbon::parse($this->argument('date'));

        $dataSource = new RundownApiProvider();

//        $period = CarbonPeriod::create(Carbon::parse($date), Carbon::now());

        foreach($leagues as $league) {

            echo 'Searching '.$league->name." games\n";

            // Iterate over the days
//            foreach($period as $date) {

                // NFL Doesn't play on Tues, Wed, Fri or Sat so skip it.
                if($league->id == Leagues::NFL_ID && in_array($date->dayOfWeek, [2,3,5,6]) && !in_array($date->month, [9,10,11,12,1,2])){
                    continue;
                }

                // NHL Doesn't play in certain months, skip it if not in that month
                if($league->id == Leagues::NHL_ID && !in_array($date->month, [10,11,12,1,2,3,4,5,6])){
                    continue;
                }

                // NBA Doesn't play in certain months, skip it if not in that month
                if($league->id == Leagues::NBA_ID && !in_array($date->month, [10,11,12,1,2,3,4])){
                    continue;
                }

                // MLB Doesn't play in certain months, skip it if not in that month
                if($league->id == Leagues::MLB_ID && !in_array($date->month, [3,4,5,6,7,8,9,10])){
                    continue;
                }

                echo $date->format('Y-m-d')."\n";
                $gamesByDate = $dataSource->getGamesByDate($date, $league);

                foreach($gamesByDate as $game) {
                    $fieldsToUpdate = [
                        'home_score'    => $game['home_score'],
                        'away_score'    => $game['away_score'],
                        'home_spread' => $game['home_spread'],
                        'away_spread' => $game['away_spread'],
                        'broadcast'     => $game['broadcast'],
                        'period'        => $game['period'],
                        'status'        => $game['status'],
                        'ended_at'      => $game['status'] == Games::ENDED ? Carbon::parse($game['start_date'])->addHours(4) : null
                    ];

                    // Update or create
                    Games::updateOrCreate([
                        'home_team_id'  => $game['home_team_id'],
                        'away_team_id'  => $game['away_team_id'],
                        'league_id'     => $game['league_id'],
                        'start_date'    => $game['start_date'],
                    ], $fieldsToUpdate);
                }

//            }
        }

    }
}

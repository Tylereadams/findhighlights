<?php

namespace App\Console\Commands;

use App\Games;
use App\Leagues;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Providers\RundownApiProvider;
use Whoops\Run;

class CommandImportGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importer:import-games';

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
        $league = Leagues::find(Leagues::NFL_ID);

        $dataSource = new RundownApiProvider();
        $gamesByDate = $dataSource->getGamesByDate(Carbon::parse('2019-10-13'), $league);

        foreach($gamesByDate as $game) {

            $fieldsToUpdate = [
                'home_score'    => $game['home_score'],
                'away_score'    => $game['away_score'],
                'broadcast'     => $game['broadcast'],
                'period'        => $game['period'],
                'status'        => $game['status'],
                'ended_at'      => NULL
            ];

            // Only update spreads if the start date is older than 12 hours ago, spreads reset to 0 after some time
            if(strtotime($game['start_date']) < strtotime('-12 hours')){
                $fieldsToUpdate['home_spread'] = $game['home_spread'];
                $fieldsToUpdate['away_spread'] = $game['away_spread'];
            }

            // Update or create
            Games::updateOrCreate([
                'home_team_id'  => $game['home_team_id'],
                'away_team_id'  => $game['away_team_id'],
                'league_id'     => $game['league_id'],
                'start_date'    => $game['start_date'],
            ], $fieldsToUpdate);
        }
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('fh:upload-tweets')
             ->everyMinute();

         // Import games from yesterday
        $schedule->command('importer:import-games "'.Carbon::now()->yesterday()->format('YYYY-mm-dd').'"')
            ->daily(2);

         // Import games for today 6 times per day
        $schedule->command('importer:import-games')
            ->twiceDaily(3, 15);
        $schedule->command('importer:import-games')
            ->twiceDaily(17, 19);
        $schedule->command('importer:import-games')
            ->twiceDaily(21, 23);

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use App\Console\Commands\GetResults;
use App\Console\Commands\ResetPredictions;
use App\Console\Commands\ResetUserMonthlyPoints;
use App\Console\Commands\ResetUserSeasonPoints;
use App\Console\Commands\ResetUserWeeklyPoints;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\ResetUserWeeklyPoints',
        'App\Console\Commands\ResetUserMonthlyPoints',
        'App\Console\Commands\ResetUserSeasonPoints',
        'App\Console\Commands\GetResults',
        'App\Console\Commands\ResetPredictions',
        'App\Console\Commands\ResetTeamPositions',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ResetUserWeeklyPoints::class)->weeklyOn(5, '12:00');
        $schedule->command(ResetUserMonthlyPoints::class)->monthlyOn(1, '00:00');
        $schedule->command(ResetUserSeasonPoints::class)->monthly()->when(function () {
            return date('M') == 6;
        });
        $schedule->command(GetResults::class)->dailyAt('00:00');
        $schedule->command(ResetPredictions::class)->everyTwoHours();
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

<?php

namespace App\Console;

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
        // Weekly Points Reset (runs every Friday at 12pm)
        $schedule->command('ResetUserWeeklyPoints')->weeklyOn(5, '12:00');

        // Monthly Points Reset (runs at midnight on 1st of every month)
        $schedule->command('ResetUserMonthlyPoints')->monthlyOn(1, '00:00');

        // Season Points Reset (runs at midnight on 1st of June annually)
        $schedule->command('ResetUserSeasonPoints')->monthly()->when(function () {
            return date('M') == 6;
        });
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

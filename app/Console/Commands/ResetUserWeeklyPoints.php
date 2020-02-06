<?php

namespace App\Console\Commands;

use App\Http\Controllers\PredictionController;
use Illuminate\Console\Command;

use App\User;

class ResetUserWeeklyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userweeklypoints:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all user\'s weekly points counts to 0.';

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
     * Update each user's 'weekly_points' DB value if isn't already 0.
     *
     * @return mixed
     */
    public function handle()
    {
        User::where('weekly_points','>',0)
            ->update(['weekly_points' => 0]);
    }
}

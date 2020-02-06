<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;

class ResetUserMonthlyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usermonthlypoints:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all user\'s monthly points counts to 0.';

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
     * Update each user's 'monthly_points' DB value if isn't already 0.
     *
     * @return mixed
     */
    public function handle()
    {
        User::where('monthly_points','>',0)
            ->update(['monthly_points' => 0]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;

class ResetUserSeasonPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userseasonpoints:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all user\'s season points counts to 0.';

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
     * Update each user's 'season_points' DB value if isn't already 0.
     *
     * @return mixed
     */
    public function handle()
    {
        User::where('season_points','>',0)
            ->update(['season_points' => 0]);
    }
}

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
     * Update each user's 'season_points' DB value and all associated teams' 'points' value to 0.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(User::all() as $user){
            $user->season_points = 0;
            $user->save();

            foreach($user->teams as $team){
                $team->points = 0;
                $team->save();
            }
        }
    }
}

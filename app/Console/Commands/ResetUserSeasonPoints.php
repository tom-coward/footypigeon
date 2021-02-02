<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\ArchivedTeam;
use Illuminate\Support\Facades\Artisan;

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
        // Call team positions reset task (to ensure no teams have `league_position` set to NULL)
        Artisan::call('teampositions:reset');

        foreach(User::all() as $user){
            $user->season_points = 0;
            $user->save();

            foreach($user->teams as $team){
                // Save team details in archive
                $archivedTeam = new ArchivedTeam();
                $archivedTeam->league_name = $team->league->name;
                $archivedTeam->points = $team->points;
                $archivedTeam->league_position = $team->position;
                $archivedTeam->manager_id = $team->manager_id;
                $archivedTeam->season_year = now()->year;
                $archivedTeam->save();

                // Revert team values to starting point for next season
                $team->points = 0;
                $team->position = NULL;
                $team->save();
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\League;
use App\Team;

class ResetTeamPositions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teampositions:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-calculate all team positions.';

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
        foreach (League::all() as $league){
            $orderedTeams = $league->teams()->orderBy('points', 'desc')->get();

            foreach ($orderedTeams as $key => $team) {
                $team->position = $key + 1;
                $team->save();
            }
        }
    }
}

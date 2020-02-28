<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Prediction;
use App\User;

class ResetPredictions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'predictions:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate predictions with new fixtures.';

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
        // Check all current prediction games have been played
        if(Prediction::all('result_recorded') == true){
            $client = new \GuzzleHttp\Client();

            // Get current round ID
            $roundRequest = $client->get('https://api-football-v1.p.rapidapi.com/v2/fixtures/rounds/2/current', [
                'headers' => [
                    'X-RapidAPI-Host' => config('api.host'),
                    'X-RapidAPI-Key' => config('api.key'),
                ]
            ]);
            $roundResponse = json_decode($roundRequest->getBody(), true);
            $currentRound = $roundResponse['api']['fixtures'][0];

            // Get all fixtures
            $fixtureRequest = $client->get('https://api-football-v1.p.rapidapi.com/v2/fixtures/league/524/'. $currentRound .'?timezone=Europe/London', [
                'headers' => [
                    'X-RapidAPI-Host' => config('api.host'),
                    'X-RapidAPI-Key' => config('api.key'),
                ]
            ]);
            $fixtureResponse = json_decode($fixtureRequest->getBody(), true);

            // Create prediction records (for each user & prediction)
            foreach(User::all() as $user){
                foreach($fixtureResponse['api']['fixtures'] as $fixture){
                    $prediction = new Prediction;
                    $prediction->user_id = $user->id;
                    $prediction->round_id = $fixture['round'];
                    $prediction->ko_time = $fixture['event_timestamp'];
                    $prediction->home_team_id = $fixture['homeTeam']['team_id'];
                    $prediction->home_team_name = $fixture['homeTeam']['team_name'];
                    $prediction->away_team_id = $fixture['awayTeam']['team_id'];
                    $prediction->away_team_name = $fixture['awayTeam']['team_name'];
                    $prediction->save();
                }
            }
        }
    }
}

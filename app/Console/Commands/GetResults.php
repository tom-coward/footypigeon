<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Prediction;
use App\Result;
use Illuminate\Support\Facades\Artisan;

class GetResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'results:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate results with final results of fixtures.';

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
        $client = new \GuzzleHttp\Client();

        $predictions = Prediction::where('result_recorded', false)->get();

        // Check if API status is 'FT' for all predictions without recorded results
        foreach($predictions as $prediction){
            if(!Result::where('id', $prediction->fixture_id)->exists()){
                $request = $client->get('https://api-football-v1.p.rapidapi.com/v2/fixtures/id/'. $prediction->fixture_id .'?timezone=Europe/London', [
                    'headers' => [
                        'X-RapidAPI-Host' => config('api.host'),
                        'X-RapidAPI-Key' => config('api.key'),
                    ]
                ]);
                $response = json_decode($request->getBody(), true);

                if($response['api']['fixtures'][0]['statusShort'] == 'FT'){
                    $result = new Result;
                    $result->id = $response['api']['fixtures'][0]['fixture_id'];
                    $result->round_id = $prediction->round_id;
                    $result->home_team_id = $prediction->home_team_id;
                    $result->home_team_name = $prediction->home_team_name;
                    $result->away_team_id = $prediction->away_team_id;
                    $result->away_team_name = $prediction->away_team_name;
                    $result->home_team_goals = $response['api']['fixtures'][0]['goalsHomeTeam'];
                    $result->away_team_goals = $response['api']['fixtures'][0]['goalsAwayTeam'];
                    $result->save();
                }else{
                    // skip updating points as no result has been recorded
                    continue;
                }
            }

            // Award user & team points
            $predictionHomeGoals = $prediction->home_team_goals;
            $predictionAwayGoals = $prediction->away_team_goals;
            $resultHomeGoals = $prediction->result->home_team_goals;
            $resultAwayGoals = $prediction->result->away_team_goals;

            $predictionHomeWin = $predictionHomeGoals > $predictionAwayGoals;
            $resultHomeWin = $resultHomeGoals > $resultAwayGoals;
            $predictionAwayWin = $predictionAwayGoals > $predictionHomeGoals;
            $resultAwayWin = $resultAwayGoals > $resultHomeGoals;
            $predictionDraw = $predictionHomeGoals == $predictionAwayGoals;
            $resultDraw = $resultHomeGoals == $resultAwayGoals;

            // Correct score (20pts)
            if($predictionHomeGoals == $resultHomeGoals AND $predictionAwayGoals == $resultAwayGoals){
                $prediction->user->increment('weekly_points', 20);
                $prediction->user->increment('monthly_points', 20);
                $prediction->user->increment('season_points', 20);

                $prediction->increment('points_awarded', 10);

                foreach($prediction->user->teams as $team){
                    $team->increment('points', 20);
                }
            }
            // Correct winner (10pts)
            elseif(($predictionHomeWin == true AND $resultHomeWin == true)
                OR ($predictionAwayWin == true AND $resultAwayWin == true)
                OR ($predictionDraw == true AND $resultDraw == true)){
                $prediction->user->increment('weekly_points', 10);
                $prediction->user->increment('monthly_points', 10);
                $prediction->user->increment('season_points', 10);

                $prediction->increment('points_awarded', 10);

                foreach($prediction->user->teams as $team){
                    $team->increment('points', 10);
                }
            }

            $prediction->result_recorded = true;
            $prediction->save();
        }

        // Call team positions reset task
        Artisan::call('teampositions:reset');
    }
}

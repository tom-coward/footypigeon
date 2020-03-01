<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Prediction;
use App\Result;

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
            $request = $client->get('https://api-football-v1.p.rapidapi.com/v2/fixtures/id/'. $prediction->id .'?timezone=Europe/London', [
                'headers' => [
                    'X-RapidAPI-Host' => config('api.host'),
                    'X-RapidAPI-Key' => config('api.key'),
                ]
            ]);
            $response = json_decode($request->getBody(), true);

            if($response['api']['fixtures'][0]['statusShort'] == 'FT'){
                $result = new Result;
                $result->id = $prediction->id;
                $result->round_id = $prediction->round_id;
                $result->home_team_id = $prediction->home_team_id;
                $result->home_team_name = $prediction->home_team_name;
                $result->away_team_id = $prediction->away_team_id;
                $result->away_team_name = $prediction->away_team_name;
                $result->home_team_goals = $response['api']['fixtures']['goalsHomeTeam'];
                $result->away_team_goals = $response['api']['fixtures']['goalsAwayTeam'];
                $result->save();

                $prediction->result_recorded = true;
                $prediction->save();
            }
        }
    }
}

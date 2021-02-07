<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Prediction;
use Illuminate\Support\Facades\DB;

class PredictionsPointsAwardedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Prediction::where('result_recorded', true)->get() as $prediction){
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
                DB::table('predictions')->where('id', $prediction->id)->update(['points_awarded' => 20]);
            }
            // Correct winner (10pts)
            elseif(($predictionHomeWin == true AND $resultHomeWin == true)
                OR ($predictionAwayWin == true AND $resultAwayWin == true)
                OR ($predictionDraw == true AND $resultDraw == true)){
                DB::table('predictions')->where('id', $prediction->id)->update(['points_awarded' => 10]);
            }
        }
    }
}

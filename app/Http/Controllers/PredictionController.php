<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Validator;
use App\Prediction;

class PredictionController extends Controller
{
    /**
     * Display the 'My Predictions' page (a listing of all active predictions).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $predictions = Auth::user()->predictions->whereNull('points_awarded');

        return view('my-predictions.index', ['predictions' => $predictions]);
    }

    /**
     * Update the user's predictions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'prediction.*.*' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect(route('my-predictions.index'))
                ->with('error', 'The predictions you entered are invalid.');
        }

        foreach($request['prediction'] as $key => $userPrediction){
            // Fetch prediction by ID
            $prediction = Prediction::findOrFail($key);

            // Verify match hasn't already started
            if(now()->timestamp >= $prediction->ko_time){
                Session::flash('error', 'You cannot change your predicted score for a match that\'s already started.');
                continue;
            }

            // Verify prediction is owned by user
            if($prediction->user_id != $request->user()->id){
                Session::flash('error', 'An error occurred. Please try again.');
                continue;
            }

            // Update user's prediction
            $prediction->home_team_goals = $userPrediction['home'];
            $prediction->away_team_goals = $userPrediction['away'];
            $prediction->save();
        }

        return back()->with('status', 'Your predictions have been successfully updated.');
    }
}

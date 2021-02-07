<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Prediction;

class ResultController extends Controller
{
    /**
     * Display the 'My Results' page (a listing of all user's predictions and associated results).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $predictions = Prediction::where([
            ['user_id', Auth::user()->id],
            ['result_recorded', true],
        ])->paginate(10);

        return view('my-results.index', ['predictions' => $predictions]);
    }
}

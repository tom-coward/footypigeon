<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Prediction;
use App\User;

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
        ])->orderBy('id', 'desc')->paginate(10);

        return view('my-results.index', ['predictions' => $predictions]);
    }

    /**
     * Display the '[User]'s Results' page (a listing of all the selected user's predictions and associated results).
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function usersPoints($id)
    {
        $user = User::findOrFail($id);

        $predictions = Prediction::where([
            ['user_id', $user->id],
            ['result_recorded', true],
        ])->orderBy('id', 'desc')->paginate(10);

        return view('my-results.user', ['user' => $user, 'predictions' => $predictions]);
    }
}

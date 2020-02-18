<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\League;
use App\Team;

class LeagueController extends Controller
{
    /**
     * Display the 'My Leagues' page (a list of all the user's joined leagues).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('my-leagues.index');
    }

    /**
     * Store a newly created league in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('my-leagues.index'))
                ->with('error', 'The league name you entered was invalid.');
        }

        // Create new league record
        $league = new League;
        $league->name = $request->name;
        $league->league_admin_id = $request->user()->id;
        $league->save();

        // Create team record for user in new league
        $team = new Team;
        $team->manager_id = $request->user()->id;
        $team->league_id = $league->id;
        $team->save();

        return redirect(route('my-leagues.show', [$league->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

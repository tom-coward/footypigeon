<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\League;
use App\Team;
use App\User;

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
     * Display the 'View League' page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the league's details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('error', 'The league name you entered was invalid.');
        }

        // Update DB record
        $league = League::findOrFail($id);
        $league->name = $request->name;
        $league->save();

        return back()->with('status', 'The league\'s details were updated successfully.');
    }

    /**
     * Invite a user to the league.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, $id)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        // TODO: Check user doesn't already have team

        if ($validator->fails()) {
            return back()->with('error', 'The invitee name you entered was invalid.');
        }

        // Get user details
        $user = User::where('name', $request->name);

        // Create new team record
        $team = new Team;
        $team->manager_id = $user->id;
        $team->league_id = $id;
        $team->save();

        return back()->with('status', 'User was successfully invited to league.');
    }

    /**
     * Remove the league from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $league = League::findOrFail($id);
        $league->delete();

        return redirect(route('my-leagues.index'))->with('status', 'The league was successfully deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        $league = League::findOrFail($id);

        return view('my-leagues.view', ['league' => $league]);
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
            'username' => 'required|string|max:255|exists:users,username',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'The invitee username you entered was invalid.');
        }

        // Get user details
        $user = User::where('username', $request->username)->first();

        // Check if user already has team
        if(Team::where([
                ['manager_id', '=', $user->id],
                ['league_id', '=', $id],
            ])->exists()) {
            return back()->with('error', 'That user is already a member of the league.');
        }

        // Create new team record
        $team = new Team;
        $team->manager_id = $user->id;
        $team->league_id = $id;
        $team->points = $user->season_points;
        $team->save();

        return back()->with('status', 'User was successfully added to the league.');
    }

    /**
     * Remove a user from the league (by a league admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, $id, $teamId)
    {
        // Fetch team
        $team = Team::findOrFail($teamId);

        // Confirm team isn't owned by league admin
        if($team->manager->id == $team->league->leagueAdmin->id){
            return back()->with('error', 'The league administrator cannot be removed from the league.');
        }

        // Delete team record
        $team->delete();

        return back()->with('status', 'User removed from the league successfully.');
    }

    /**
     * Remove a user from the league.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function leave(Request $request, $id)
    {
        $userId = $request->user()->id;
        $leagueAdminId = League::findOrFail($id)->league_admin_id;

        // Ensure user isn't league admin
        if($userId == $leagueAdminId){
            return back()->with('error', 'You cannot leave a league you are the administrator of.');
        };

        // Remove user's team record
        $team = Team::where([
            'manager_id' => $userId,
            'league_id' => $id,
        ]);
        $team->delete();

        return redirect(route('my-leagues.index'))->with('status', 'You left the league successfully.');
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

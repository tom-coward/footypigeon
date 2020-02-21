<?php

namespace App\Http\Middleware;

use Closure;

use App\League;

class CheckIfLeagueAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $leagueAdminId = League::find($request->route('id'))->leagueAdmin->id;
        $userId = $request->user()->id;

        if($leagueAdminId != $userId){
            return redirect('leagues.index')->with('status', 'You must be the league\'s administrator to do that.');
        };

        return $next($request);
    }
}

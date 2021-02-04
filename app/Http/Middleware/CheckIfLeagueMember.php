<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfLeagueMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $leagueId = $request->route('id');

        if(!$user->teams()->where('id', $leagueId)->first()){
            return redirect()->route('my-leagues.index')->with('error', 'You\'re not a member of that league.');
        }

        return $next($request);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the admin of the league.
     */
    public function leagueAdmin()
    {
        return $this->belongsTo('App\User', 'league_admin_id');
    }

    /**
     * Get the teams in the league.
     */
    public function teams()
    {
        return $this->hasMany('App\Team');
    }
}

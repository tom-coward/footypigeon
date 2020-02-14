<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'points' => '0',
    ];

    /**
     * Get the team's league.
     */
    public function league()
    {
        return $this->belongsTo('App\League');
    }

    /**
     * Get the team's manager.
     */
    public function manager()
    {
        return $this->hasMany('App\User', 'manager_id');
    }
}

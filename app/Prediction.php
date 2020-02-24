<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
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
        'result_recorded' => false,
        'home_team_goals' => 0,
        'away_team_goals' => 0,
    ];

    /**
     * Get the prediction's user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

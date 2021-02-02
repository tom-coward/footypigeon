<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'weekly_points' => '0',
        'monthly_points' => '0',
        'season_points' => '0',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's teams.
     */
    public function teams()
    {
        return $this->hasMany('App\Team', 'manager_id');
    }

    /**
     * Get the user's archived teams.
     */
    public function archivedTeams()
    {
        return $this->hasMany('App\ArchivedTeam', 'manager_id');
    }

    /**
     * Get the user's predictions.
     */
    public function predictions()
    {
        return $this->hasMany('App\Prediction');
    }
}

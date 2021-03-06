<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Prediction extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * Get the prediction's user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the prediction fixture's result.
     */
    public function result()
    {
        return $this->belongsTo('App\Result', 'fixture_id');
    }
}

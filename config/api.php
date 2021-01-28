<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Host
    |--------------------------------------------------------------------------
    |
    | The Rapid API application key to allow access to the API Football API.
    |
    */

    'host' => env('API_HOST', 'api-football-v1.p.rapidapi.com'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | The Rapid API application key to allow access to the API Football API.
    |
    */

    'key' => env('API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | API League ID
    |--------------------------------------------------------------------------
    |
    | The Rapid API league ID used to access data for the current Premier League season.
    |
    */

    'league_id' => env('API_LEAGUE_ID'),

];

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Welcome Page
 */
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

/*
 * Authentication System & Account Settings
 */
Auth::routes();
Route::get('/account-settings', 'AccountSettingsController@index')->name('account-settings')->middleware('auth');

// Routes protected by login
Route::middleware('auth')->group(function() {
    /*
 * Dashboard
 */
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    /*
     * My Leagues
     */
    Route::prefix('leagues')->name('my-leagues.')->group(function () {
        Route::get('/', 'LeagueController@index')->name('index');
    });
    /*
     * My Predictions
     */
    Route::prefix('predictions')->name('my-predictions.')->group(function () {
        Route::get('/', 'PredictionController@index')->name('index');
    });
});

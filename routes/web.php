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
Route::get('/', 'WelcomeController@index')->middleware('guest');

/*
 * Authentication System & Account Settings
 */
Auth::routes();
Route::get('/account-settings', 'AccountSettingsController@index')->name('account-settings')->middleware('auth');
Route::post('/account-settings', 'AccountSettingsController@update')->name('account-settings.update')->middleware('auth');
Route::post('/account-settings/password-reset', 'AccountSettingsController@resetPassword')->name('account-settings.password-reset')->middleware('auth');

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
        Route::post('/create', 'LeagueController@store')->name('store');
        Route::get('/view/{id}', 'LeagueController@show')->name('show')->middleware('leagueMember');
        Route::put('/update/{id}', 'LeagueController@update')->name('update')->middleware('leagueAdmin');
        Route::post('/invite/{id}', 'LeagueController@invite')->name('invite')->middleware('leagueAdmin');
        Route::post('/remove/{id}/{teamId}', 'LeagueController@remove')->name('remove')->middleware('leagueAdmin');
        Route::post('/leave/{id}', 'LeagueController@leave')->name('leave')->middleware('leagueMember');
        Route::delete('/delete/{id}', 'LeagueController@destroy')->name('destroy')->middleware('leagueAdmin');
    });

    /*
     * My Predictions
     */
    Route::prefix('predictions')->name('my-predictions.')->group(function () {
        Route::get('/', 'PredictionController@index')->name('index');
        Route::put('/', 'PredictionController@update')->name('update');
    });
});

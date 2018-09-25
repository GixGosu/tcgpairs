<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//List most recent tournaments, paginated.
Route::get('tournaments', 'TournamentController@index');

//Open a single tournament
Route::get('tournament/{id}', 'TournamentController@show');

//Create new tournament
Route::post('tournament', 'TournamentController@create');

//Update existing tournament
Route::put('tournament/{id}', 'TournamentController@update');

//Delete tournament
Route::delete('tournament/{id}', 'TournamentController@destroy');
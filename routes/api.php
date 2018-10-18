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
/**********************
 * Tournament routing *
 **********************/

//List recent tournaments
Route::get('tournaments', 'Api\\TournamentController@index');
    //Optional: perPage [10], page

//Create new tournament
Route::post('tournaments', 'Api\\TournamentController@create');     
    //Required: gameId, formatId, title

//Edit a tournament
Route::put('tournaments', 'Api\\TournamentController@update');
    //Required: tournamentId
    //Optional: gameId, formatId, title

//Get data for one tournament
Route::get('tournaments/{id}', 'Api\\TournamentController@show');
    //Required: url(id)

//Delete a tournament from record (SoftDelete)
Route::delete('tournaments/{id}', 'Api\\TournamentController@destroy');
    //Required: url(id)



/***********************
 *    Round routing    *
 ***********************/
//List rounds in a given tournament
Route::get('tournaments/{tournamentId}/rounds', 'Api\\RoundController@index');
    //Required: url(tournamentId)

//Create next round
Route::post('tournaments/{tournamentId}/rounds', 'Api\\RoundController@create');
    //Required: url(tournamentId)

//Get a rounds list of matches
Route::get('rounds/{id}/matches', 'Api\\RoundController@matches');
    //Required: url(id)

//Delete a round
Route::delete('rounds/{id}', 'Api\\RoundController@destroy');
    //Required: url(id)

//Create pairings for a new round
Route::post('rounds/{id}/pair', 'Api\\RoundController@pair');
    //Required: url(id)
    //Not implemented (byes)

    
/***********************
 * Roster/Team routing *
 ***********************/
//Register a new team / player for a tournament
Route::post('tournaments/{tournamentId}/roster', 'Api\\RosterController@register');
    //Required: url(tournamentId), players[*]['id']
    //Optional: teamName, players[*]['slot']

//List player roster
Route::get('tournaments/{tournamentId}/roster', 'Api\\RosterController@index');
    //Required: url(tournamentId)
    //Optional: perPage, page

//Delete a player from a tournament (does not delete team)
Route::delete('rosters/{id}', 'Api\\RosterController@destroy');
    //Required: url(id)

//Delete a team from a tournament (deletes both team and associated players)
Route::delete('teams/{id}', 'Api\\RosterController@destroyTeam');
    //Required: url(id)

Route::resources([
    'games' => 'Api\\GameController',
    'formats' => 'Api\\FormatController',
]);
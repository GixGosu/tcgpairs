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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tournament/index', function () {
    return view('tournament.index');
});

Route::get('/tournament/create', function () {
    return view('tournament.create');
});

Route::get('/game/index', function () {
    return view('game.index');
});

Route::get('/player/index', function () {
    return view('player.index');
});

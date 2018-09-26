<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Formats
        Schema::table('formats', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games');
        });
        //Tournaments
        Schema::table('tournaments', function (Blueprint $table) {
            $table->foreign('format_id')->references('id')->on('formats');
            $table->foreign('game_id')->references('id')->on('games');
        });
        //Rounds
        Schema::table('rounds', function (Blueprint $table) {
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
        //Matches
        Schema::table('matches', function (Blueprint $table) {
            $table->foreign('round_id')->references('id')->on('rounds');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
        //Seats
        Schema::table('seats', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('round_id')->references('id')->on('rounds');
            $table->foreign('match_id')->references('id')->on('matches');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
        //Teams
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
        //Roster
        Schema::table('rosters', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

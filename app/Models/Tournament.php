<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    //
    use SoftDeletes;
    protected $table = 'tournaments';
    protected $guarded = ['id'];
    protected $dates = [
        'event_time', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $casts = [
        'done' => 'boolean',
    ];

    public function hasMatches () {
        return $this->hasMany('App\Models\Match', 'tournament_id', 'id');
    }

    public function hasRounds () {
        return $this->hasMany('App\Models\Round', 'tournament_id', 'id');
    }

    public function format () {
        return $this->hasOne('App\Models\Format', 'id', 'format_id');
    }

    public function game () {
        return $this->hasOne('App\Models\Game', 'id', 'game_id');
    }

    public function roster () {
        return $this->hasMany('App\Models\Roster', 'tournament_id', 'id');
    }

    public function createRound () {
        $round = new Round ($this->id);
        $round->sequenced = count($this->rounds) + 1;
        $round->save();

        /*
         Grab a list of unique teams that are sorted by the players wins, then draws.
         Formated as 
         [
             team => [
                 Roster::player1, Roster::player2...
             ],
         ]
         */
        $teams = $this->roster->available()->teams();
        $unpaired = array_keys($teams->toArray());
        $paired = [];
        $matches = [];

        foreach ($teams as $team => $players) {
            $match = [$team];
            foreach ($unpaired as $delete => $free) {
                if (!in_array($free->team_id, $player->played)) {
                    //Remove team from $unpaired
                    array_slice($unpaired, array_search($delete, $unpaired));

                    //Add team to the match
                    array_push($match, $free);

                    //Add team to being paired
                    array_push($paired, $free);
                }

                if (count($match) == $this->format->number_of_teams) {
                    array_push($matches, $match);
                    $match = [];
                    break;
                }
            }
        }
    }
}

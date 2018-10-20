<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Round extends Model
{
    //
    use SoftDeletes;
    protected $table = 'rounds';
    protected $guarded = ['id'];
    protected $touches = ['tournament'];
    protected $casts = [
        'paired' => 'boolean',
        'reported' => 'boolean',
    ];

    public function __construct () {
        
    }
    
    public function tournament () {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function matches () {
        return $this->hasMany('App\Models\Match');
    }
    
    public function seats () {
        return $this->hasMany('App\Models\Seat');
    }

    public function teams () {
        return $this->hasMany('App\Models\Team', 'tournament_id', 'tournament_id');
    }

    public function createMatches () {
        $teams = Team::where('tournament_id', $this->tournament_id)->where('active', true)->get()->sortByDesc('draws')->sortByDesc('wins');
        $unpaired = $teams->pluck('id', 'id')->toArray();
        $paired = [];
        $matches = [];

        foreach ($teams as $team) {
            if (!in_array($team->id, $paired)) {
                $match = [$team->id];
                //Remove team from $unpaired $id[key==value]
                $unpaired = array_filter($unpaired, function ($value) use ($team) {
                    return ($value == $team->id)?false:true;
                });
                array_push($paired, $team->id);
                foreach ($unpaired as $id) {
                    //Makes sure the teams haven't played each other yet
                    if (!in_array($id, $paired) && (!isset($team->played) || !in_array($id, $team->played))) {
                        //Remove team from $unpaired $id[key==value]
                        $unpaired = array_filter($unpaired, function ($value) use ($id) {
                            return ($value == $id)?false:true;
                        });

                        array_push($match, $id);
                        array_push($paired, $id);
                    }

                    //If quantity of teams in $match is how many the format requires...
                    if (count($match) == $this->tournament->format->number_of_teams) {
                        array_push($matches, $match);
                        $match = [];
                        //Break out of foreach loop
                        break;
                    }
                }
            }
        }

        //dd([$matches, $paired, $unpaired]);

        //Logic for incomplete matches caused by total teams not being a multiple of formats.number_of_teams
        if (!empty($match)) {
            $diff = $this->tournament->format->number_of_teams - count($match);
            if ($diff == 1) {
                //Give bye to last match
                array_push($match, 0);
                array_push($matches, $match);
            } elseif ($diff > 1) {
                //Multiplayer FFA logic
                //Take the last addition of previous matches until only missing 1 seat
                for ($current = 1; $current < $diff; $current++) {
                    array_push($match, array_pop($matches[count($matches)-$current]));
                    $match = [];
                }
            } else {
                return false;
            }
        }
        $table = 0;
        //Actually create the matches in the database
        //Break array down to each match
        foreach ($matches as $ids) {
            $table++;
            $match = new Match;
            $match->tournament_id = $this->tournament_id;
            $match->round_id = $this->id;
            $match->table_id = $table;
            $match->save();
            //Break match down to each team
            foreach ($ids as $id) {
                //Break team down to each player
                if ($id !== 0) {
                    foreach ($teams->where('id', $id)->first()->players as $player) {
                        $seat = new Seat ($match);
                        $seat->team_id = $id;
                        $seat->player_id = $player->id;
                        $seat->tournament_id = $this->tournament_id;
                        $seat->round_id = $this->id;
                        $seat->match_id = $match->id;
                        $seat->save();
                    }
                } else {
                    $seat = new Seat ($match);
                    $seat->team_id = 0;
                    $seat->player_id = 0;
                    $seat->tournament_id = $this->tournament_id;
                    $seat->round_id = $this->id;
                    $seat->match_id = $match->id;
                    $seat->save();
                }
            }
        }

        $this->paired = true;
        $this->save();
        return true;
    }

}

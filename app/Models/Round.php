<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Round extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;
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
        $teams = Team::tournament($this->tournament_id)->active()->withPoints()->get()->sortByDesc('points');
        $numberOfTeams = $this->tournament->format->number_of_teams;
        $numberOfByes = $teams->count() % $numberOfTeams;
        $this->unpaired = $teams->pluck('id')->toArray();

        //Pair the full tables first
        $this->pairMatches($teams, $numberOfTeams, $numberOfByes);

        //Pair tables with empty seats / byes
        $byes = $teams->whereIn('id', $this->unpaired);
        $this->pairMatches($byes, $numberOfTeams - 1, 0);

        //Save paired matches in database
        $this->saveMatches();


        /*
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
        return true;*/
    }

    public function pairMatches ($teams, $numberOfTeams, $ignore) {
        $match = [];
        $this->pairedMatches = [];
        while (count($this->unpaired) > $ignore * ($numberOfTeams - 1)) {
            //Starting a new match
            if (empty($match)) {
                //Find first unpaired player and remove them from array
                $team = $teams->where('id', array_shift($this->unpaired))->first();
                $played = $team->played();
                $match = [$team->id];
            }
            //Finding opponent for match
            if (count($match) < $numberOfTeams) {
                $validOpponents = $teams->whereIn('id', $this->unpaired)->whereNotIn('id', $played)->sortByDesc('points');
                if (!empty($validOpponents)) {
                    $opponent = $validOpponents->first();
                    array_push($match, $opponent->id);
                    $this->unpaired = array_diff($this->unpaired, [$opponent->id]);
                    $played = array_merge($opponent->played(), $played);
                } else {
                    //No valid opponents, add players back to the end of the unpaired array
                    array_merge($this->unpaired, $match);
                    $match = [];
                    $played = [];
                }
            }
            //Saving match & reseting variables
            if (count($match) == $numberOfTeams) {
                array_push($this->pairedMatches, $match);
                $match = [];
                $played = [];
            }
        }
    }

    public function saveMatches () {
        array_walk($this->pairedMatches, function($match, $index) {
            $insert = [];

            $newMatch = new Match ();
            $newMatch->tournament_id = $this->tournament_id;
            $newMatch->round_id = $this->id;
            $newMatch->table_id = $index + 1;
            $newMatch->save();

            array_walk($match, function ($value, $key) use ($newMatch) {
                foreach (Team::find($value)->players as $player) {
                    array_push($insert, [
                        'team_id' => $value,
                        'match_id' => $newMatch->id,
                        'round_id' => $this->id,
                        'player_id' => $player->id,
                        'tournament_id' => $this->tournament_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

            Seat::insert($insert);
        });
    }

}

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
        $teams = Team::getTournament($this->tournament_id)->active()->withPoints()->get()->sortByDesc('points');
        $numberOfTeams = $this->tournament->format->number_of_teams;
        $numberOfByes = $teams->count() % $numberOfTeams;
        $this->unpaired = $teams->pluck('id')->toArray();

        //Pair the full tables first
        $paired = $this->pairMatches($teams, $numberOfTeams, $numberOfByes);

        //Pair tables with empty seats / byes
        $byes = $teams->whereIn('id', $this->unpaired);
        $paired = array_merge($paired, $this->pairMatches($byes, $numberOfTeams - 1, 0));

        //Save paired matches in database
        $this->saveMatches($paired);


    }

    public function pairMatches ($teams, $numberOfTeams, $ignore) {
        $match = [];
        $pairedMatches = [];
        while (count($this->unpaired) > $ignore * ($numberOfTeams - 1)) {
            //Starting a new match
            if (empty($match)) {
                //Find first unpaired player and remove them from array
                $teamId = $this->unpaired[0];
                $this->unpaired = array_diff($this->unpaired, [$teamId]);
                $team = $teams->where('id', $teamId)->first();
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
                array_push($pairedMatches, $match);
                $match = [];
                $played = [];
            }
        }

        return $pairedMatches;
    }

    public function saveMatches ($paired) {
        array_walk($paired, function($match, $index) {
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

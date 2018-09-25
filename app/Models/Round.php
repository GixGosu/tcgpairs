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
    protected $touches = ['inTournament'];

    public function __construct ($tournament_id) {
        $this->tournament_id = $tournament_id;
    }
    
    public function inTournament () {
        return $this->belongsTo('App\Models\Tournament', 'tournament_id');
    }

    public function hasMatches () {
        return $this->hasMany('App\Models\Match', 'round_id', 'id');
    }
    
    public function hasSeats () {
        return $this->hasMany('App\Models\Seat', 'round_id', 'id');
    }

    public function createMatch () {
        
    }

}

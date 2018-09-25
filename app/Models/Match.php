<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Match extends Model
{
    //
    use SoftDeletes;
    protected $table = 'matches';
    protected $guarded = ['id'];
    protected $touches = ['inRound', 'inTournament'];

    public function hasSeats () {
        return $this->hasMany('App\Models\Seat', 'match_id', 'id');
    }

    public function inRound () {
        return $this->belongsTo('App\Models\Round', 'round_id');
    }

    public function inTournament () {
        return $this->belongsTo('App\Models\Tournament', 'tournament_id');
    }
}

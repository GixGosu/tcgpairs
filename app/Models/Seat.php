<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $touches = ['inMatch', 'inRound', 'inTournament'];
    
    public function inMatch () {
        return $this->belongsTo('App\Models\Match', 'match_id');
    }

    public function inRound () {
        return $this->belongsTo('App\Models\Round', 'round_id');
    }

    public function inTournament () {
        return $this->belongsTo('App\Models\Tournament', 'tournament_id');
    }
}

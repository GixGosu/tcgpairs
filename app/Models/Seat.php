<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $touches = ['match', 'round', 'tournament'];

    public function __construct () {
    }
    
    public function match () {
        return $this->belongsTo('App\Models\Match');
    }

    public function round () {
        return $this->belongsTo('App\Models\Round');
    }

    public function tournament () {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function scopeTeam ($query, $teamId) {
        return $query->where('team_id', $teamId);
    }

    public function scopeExclude ($query, $teamId) {
        return $query->where('team_id', '<>', $teamId);
    }
}

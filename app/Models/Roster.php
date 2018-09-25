<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roster extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $touches = ['player', 'tournament'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function player() {
        return $this->belongsTo('App\Models\Player', 'player_id');
    }

    public function tournament() {
        return $this->belongsTo('App\Models\Tournament', 'tournament_id');
    }

    public function scopeTeams($query) {
        return $query->groupBy('team');
    }

    public function scopeAvailable($query) {
        return $query->where('active', true)->sortByDesc('draws')->sortByDesc('wins');
    }
}

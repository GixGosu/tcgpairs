<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $guarded = ['id'];
    protected $touches = ['tournament'];
    protected $casts = [
        'active' => 'boolean',
        'played' => 'array',
    ];
    
    public function players() {
        return $this->hasMany('App\Models\Roster');
    }

    public function tournament() {
        return $this->belongsTo('App\Models\Tournament');
    }
    
    public function scopeAvailable($query) {
        return $query->where('active', true)->sortByDesc('draws')->sortByDesc('wins');
    }

    public function scopeWithPoints($query) {
        return $query->select('*', \DB::raw('(wins + byes) * 3 + draws as points'));
    }

    public function scopeActive($query) {
        return $query->where('active', true);
    }

    public function scopeTournament($query, $tournamentId) {
        return $query->where('tournament_id', $tournamentId);
    }

    public function getPointsAttribute() {
        return ($this->wins + $this->byes) * 3 + $this->draws;
    }

    public function played () {
        $matches = Seat::team($this->id)->get()->pluck('match_id')->toArray();
        return Seat::exclude($this->id)->whereIn('match_id', $matches)->get()->pluck('team_id')->toArray();
    }
}

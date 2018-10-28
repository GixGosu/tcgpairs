<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Roster extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;

    protected $guarded = ['id'];
    protected $touches = ['tournament'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function team () {
        return $this->belongsTo('App\Models\Team');
    }

    public function player () {
        return $this->belongsTo('App\Models\Player');
    }

    public function tournament() {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function scopeAvailable($query) {
        return $query->where('active', true)->sortByDesc('draws')->sortByDesc('wins');
    }

    public function scopeCheckPlayers($query, $t, $p) {
        $ids = collect($p)->pluck('playerId')->toArray();
        return $query->where('tournament_id', $t)
            ->whereIn('player_id', $ids)
            ->join('players', 'players.id', 'rosters.player_id')
            ->select('players.f_name', 'players.l_name');
    }
}

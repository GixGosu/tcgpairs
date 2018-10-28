<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Tournament extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;
    
    protected $table = 'tournaments';
    protected $guarded = ['id'];
    protected $dates = [
        'event_time', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $casts = [
        'done' => 'boolean',
    ];

    public function matches () {
        return $this->hasMany('App\Models\Match');
    }

    public function rounds () {
        return $this->hasMany('App\Models\Round')->orderby('created_at')->orderBy('sequenced');
    }

    public function format () {
        return $this->belongsTo('App\Models\Format');
    }

    public function game () {
        return $this->belongsTo('App\Models\Game');
    }

    public function teams () {
        return $this->hasMany('App\Models\Team');
    }

    public function roster () {
        return $this->hasMany('App\Models\Roster');
    }

    public function createRound () {
        if (!empty($this->rounds->last()) && !$this->rounds->last()->reported)
            return false;
        
        $round = new Round;
        $round->tournament_id = $this->id;
        $round->sequenced = count($this->rounds) + 1;
        $round->save();

        return $round;
    }
}

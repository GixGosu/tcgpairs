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
    protected $touches = ['round', 'tournament'];

    public function __construct ($round = null) {
        if (isset($round)) {
            $this->tournament_id = $round->tournament_id;
            $this->round_id = $round->id;
        }
    }

    public function seats () {
        return $this->hasMany('App\Models\Seat');
    }

    public function round () {
        return $this->belongsTo('App\Models\Round');
    }

    public function tournament () {
        return $this->belongsTo('App\Models\Tournament');
    }
}
<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Match extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;

    protected $table = 'matches';
    protected $guarded = ['id'];
    protected $touches = ['round', 'tournament'];

    public function __construct () {
        
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

    public function scopeReported ($query) {
        return $query->where('reported', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roster extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $touches = ['tournament'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function tournament() {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function scopeAvailable($query) {
        return $query->where('active', true)->sortByDesc('draws')->sortByDesc('wins');
    }
}

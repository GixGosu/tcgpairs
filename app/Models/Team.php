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
}

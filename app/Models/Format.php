<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    //
    use SoftDeletes;
    
    protected $guarded = ['id'];
    protected $touches = ['game'];
    protected $casts = [
        'is_slotted' => 'boolean',
        'is_draft' => 'boolean',
        'is_ffa' => 'boolean',
    ];

    public function game () {
        return $this->belongsTo('App\Models\Game', 'game_id');
    }
}

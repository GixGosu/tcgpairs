<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Format extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;
    
    protected $guarded = ['id'];
    protected $touches = ['game'];
    protected $casts = [
        'is_slotted' => 'boolean',
        'is_draft' => 'boolean',
        'is_ffa' => 'boolean',
    ];

    public function game () {
        return $this->belongsTo('App\Models\Game');
    }
}

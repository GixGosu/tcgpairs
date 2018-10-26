<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Game extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;

    protected $guarded = ['id'];

    public function formats () {
        return $this->hasMany('App\Models\Format');
    }
}

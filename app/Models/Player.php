<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Player extends Model implements Sortable
{

    use SortableTrait, SoftDeletes, Orderable;

    protected $table = 'players';
    protected $guarded = ['id'];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function getFLNameAttribute() {
        return ucfirst(strtolower($this->f_name)) . ' ' . ucfirst(strtolower($this->l_name));
    }

    public function getLFNameAttribute() {
        return ucfirst(strtolower($this->l_name)) . ', ' . ucfirst(strtolower($this->f_name));
    }

}

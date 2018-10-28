<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Location extends Model implements Sortable
{

    use SortableTrait, Orderable;

    public function setLatitudeAttribute ($value) {
        $this->attributes['latitude'] = $value * 1000;
    }

    public function getLatitudeAttribute ($value) {
        return $value / 1000;
    }

    public function setLongitudeAttribute ($value) {
        $this->attributes['longitude'] = $value * 1000;
    }

    public function getLongitudeAttribute ($value) {
        return $value / 1000;
    }
}

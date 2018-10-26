<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //

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

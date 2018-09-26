<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    //
    use SoftDeletes;
    protected $table = 'players';
    protected $guarded = ['id'];

    public function getFLNameAttribute() {
        return ucfirst(strtolower($this->f_name)) . ' ' . ucfirst(strtolower($this->l_name));
    }
    
    public function getLFNameAttribute() {
        return ucfirst(strtolower($this->l_name)) . ', ' . ucfirst(strtolower($this->f_name));
    }

}

<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Tournament;
use App\Http\Resources\Roster;
use App\Http\Resources\Round;
use App\Http\Resources\Team;

class Tournaments extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'data' => Tournament::collection($this->collection),
        ];
    }
    
}

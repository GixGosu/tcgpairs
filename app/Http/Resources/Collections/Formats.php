<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Format;

class Formats extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => Format::collection($this->collection),
        ];
    }
}

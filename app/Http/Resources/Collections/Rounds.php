<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Round;

class Rounds extends ResourceCollection
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
            'data' => Round::collection($this->collection),
        ];
    }

    public function with ($request) {
        return array_merge(parent::with($request), [
            'relationships' => [
                'tournament' => $this->collection->first()->tournament,
            ],
        ]);
    }
}

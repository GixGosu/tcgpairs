<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Roster;

class Rosters extends ResourceCollection
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
            'data' => Roster::collection($this->collection)
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

<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Game;

class Games extends ResourceCollection
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
            'data' => Game::collection($this->collection),
        ];
    }
}

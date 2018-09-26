<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

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
            'totalItems' => $this->collection->count(),
        ];
    }

    public function with($request) 
    {
        return [
            'success' => true,
            'errors' => [],
        ];
    }
}

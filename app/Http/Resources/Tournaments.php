<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

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

    public function with($request) 
    {
        return [
            'success' => true,
            'errors' => [],
            'totalItems' => $this->collection->count(),
        ];
    }
}

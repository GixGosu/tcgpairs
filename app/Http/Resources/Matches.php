<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Matches extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
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

<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
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

    /**
     * Set with () function
     */
    public function with ($request)
    {
        return [
            'success' => true,
            'errors' => [],
            'totalItems' => $this->collection->count(),
        ];
    }
}

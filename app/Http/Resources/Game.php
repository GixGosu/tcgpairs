<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Game extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'abbrv' => $this->abbrv,
            'relationships' => [
                'formats' => $this->formats,
            ],
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

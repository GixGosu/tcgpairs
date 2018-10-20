<?php

namespace App\Http\Resources;

class Game extends BaseResource
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
        return parent::with($request)
    }
}

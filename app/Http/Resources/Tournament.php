<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tournament extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'done' => $this->done,
            'title' => $this->title,
            'event_time' => $this->event_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'relationships' => [
                'game' => $this->game,
                'format' => $this->format,
                'rounds' => $this->when(!empty($this->rounds), new Rounds ($this->rounds)),
                'teams' => $this->teams,
                'roster' => $this->roster,
            ]
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

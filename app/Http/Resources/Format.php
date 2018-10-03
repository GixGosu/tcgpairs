<?php

namespace App\Http\Resources;

class Format extends BaseResource
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
            'type' => $this->type,
            'team_size' => $this->team_size,
            'teams_per_match' => $this->teams_per_match,
            'is_slotted' => $this->is_slotted,
            'is_draft' => $this->is_draft,
            'is_ffa' => $this->is_ffa,

            'relationships' => [
                'game' => $this->game,
            ],
        ];
    }

    public function with($request) 
    {
        return parent::with($request)
    }
}

<?php

namespace App\Http\Resources;

class Round extends BaseResource
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
            'paired' => $this->paired,
            'sequenced' => $this->sequenced,
            'tournament' => $this->tournament->title,
            'tournamentId' => $this->tournament_id,
        ];
    }

    public function with($request) 
    {
        return array_merge(parent::with($request),[
            'relationships' => [
                'matches' => $this->matches,
            ],
        ]);
    }
}

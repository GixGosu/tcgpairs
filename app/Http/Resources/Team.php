<?php

namespace App\Http\Resources;

use App\Models\Team as TeamModel;

class Team extends BaseResource
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
            'active' => $this->active,
            'teamName' => $this->team_name,
            'wins' => $this->wins,
            'draws' => $this->draws,
            'losses' => $this->losses,
            'byes' => $this->byes,
        ];
    }

    public function with($request) 
    {
        return array_merge(parent::with($request),[
            'relationships' => [
                'players' => Roster::collection($this->players),
            ],
        ]);
    }
}

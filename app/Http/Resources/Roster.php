<?php

namespace App\Http\Resources;

use App\Models\Player as PlayerModel;

class Roster extends BaseResource
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
            'active' => $this->active,
            'playerId' => $this->player_id,
            'playerName' => $this->player->l_f_name,
            'teamName' => $this->team->team_name,
            'wins' => $this->team->wins,
            'losses' => $this->team->losses,
            'draws' => $this->team->draws,
            'byes' => $this->team->byes,
            'active' => $this->active,
            'teamActive' => $this->team->active,
        ];
    }

    public function with($request) 
    {
        return parent::with($request);
    }
}

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
        ];
    }

    public function with($request) 
    {
        return parent::with($request);
    }
}

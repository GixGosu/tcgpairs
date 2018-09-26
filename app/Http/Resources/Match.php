<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Match extends JsonResource
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
            'table_id' => $this->table_id,
            'seats' => $this->seats->each(function ($seat) {
                return [
                    'id' => $seat->id,
                    'player' => $seat->player->l_f_name,
                    'player_id' => $seat->player_id,
                ];
            }),

            'relationships' => [
                'tournament' => $this->tournament,
                'round' => $this->round,
            ],
        ];
    }
}

<?php

namespace App\Http\Resources;

class Match extends BaseResource
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
        ];
    }

    public function with($request) 
    {
        return array_merge(parent::with($request), [
            'relationships' => [
                'tournament' => $this->tournament,
                'round' => $this->round,
            ]
        ]);
    }
}

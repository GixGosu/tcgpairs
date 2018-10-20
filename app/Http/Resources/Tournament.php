<?php

namespace App\Http\Resources;

use App\Http\Resources\Collections\Rounds;

class Tournament extends BaseResource
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
            'game' => $this->game->title,
            'gameId' => $this->game_id,
            'format' => $this->format->title,
            'formatId' => $this->format_id,
            'eventTime' => $this->event_time,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }

    public function with ($request) {
        return array_merge(parent::with($request), [
            'relationships' => [
                'game' => $this->game,
                'format' => $this->format,
                'roster' => Roster::collection($this->roster),
                'rounds' => Round::collection($this->rounds),
                'teams' => Team::collection($this->teams),
            ],
        ]);
    }
}

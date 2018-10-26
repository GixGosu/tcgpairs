<?php

namespace App\Traits;

trait Orderable {
    public function scopeSetOrder($query, $sortBy = 'createdAt', $sortOrder = 'desc') {
        $translation = [
            'game' => 'game_id',
            'title' => 'title',
            'format' => 'format_id',
            'eventTime' => 'event_time',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];

        return $query->orderBy($translation[$sortBy], $sortOrder);
    }
}
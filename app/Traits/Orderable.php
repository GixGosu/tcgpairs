<?php

namespace App\Traits;

trait Orderable {
    public function scopeSetOrder($query, $sortBy, $sortOrder = 'desc') {
        $translation = [
            'game' => 'game_id',
            'title' => 'title',
            'format' => 'format_id',
            'eventTime' => 'event_time',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
            'default' => 'order_column'
        ];

        $sortBy = array_key_exists($sortBy, $translation) ? $sortBy : 'default';

        return $query->orderBy($translation[$sortBy], $sortOrder);
    }
}
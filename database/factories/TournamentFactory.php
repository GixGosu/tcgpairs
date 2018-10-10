<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Tournament::class, function (Faker $faker) {
    return [
        'game_id' => 25,
        'format_id' => 1,
        'title' => $faker->words(4, true),
        'event_time' => $faker->dateTime(),
        'done' => 0
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Player::class, function (Faker $faker) {
    $parts = collect(explode(' ', $faker->name));
    return [
        'f_name' => $parts->first(),
        'l_name' => $parts->last(),
        'email' => $faker->unique()->safeEmail,
    ];
});

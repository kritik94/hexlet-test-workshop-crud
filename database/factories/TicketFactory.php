<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'reporter' => $faker->email(),
    ];
});
$factory->state(App\Ticket::class, 'opened', function (Faker $faker) {
    return [
        'status' => App\Ticket::STATUS_OPENED,
        'rating' => 0,
    ];
});

<?php

$factory->define(App\OrderStatus::class, function (Faker\Generator $faker) {
    return [
        "observacao" => $faker->name,
        "data" => $faker->date("d/m/Y H:i:s", $max = 'now'),
    ];
});

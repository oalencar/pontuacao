<?php

$factory->define(App\Models\OrderStatus::class, function (Faker\Generator $faker) {
    return [
        "observacao" => $faker->name,
        "data" => $faker->date("d/m/Y H:i:s", $max = 'now'),
    ];
});

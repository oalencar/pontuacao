<?php

$factory->define(App\Models\Score::class, function (Faker\Generator $faker) {
    return [
        "order_id" => factory('App\Models\Order')->create(),
        "user_id" => factory('App\User')->create(),
        "score" => $faker->randomNumber(2),
    ];
});

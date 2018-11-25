<?php

$factory->define(App\Score::class, function (Faker\Generator $faker) {
    return [
        "order_id" => factory('App\Order')->create(),
        "user_id" => factory('App\User')->create(),
        "score" => $faker->randomNumber(2),
    ];
});

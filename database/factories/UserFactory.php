<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "email" => $faker->safeEmail,
        "password" => str_random(10),
        "role_id" => factory('App\Models\Role')->create(),
        "remember_token" => $faker->name,
    ];
});

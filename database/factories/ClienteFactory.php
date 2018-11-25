<?php

$factory->define(App\Cliente::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "email" => $faker->safeEmail,
        "email_alternative" => $faker->safeEmail,
        "phone" => $faker->safeEmail,
        "company_id" => factory('App\Company')->create(),
    ];
});

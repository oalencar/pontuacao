<?php

$factory->define(App\Award::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->name,
        "description" => $faker->name,
        "goal" => $faker->randomNumber(2),
        "start_date" => $faker->date("d/m/Y", $max = 'now'),
        "finish_date" => $faker->date("d/m/Y", $max = 'now'),
        "partner_type_id" => factory('App\PartnerType')->create(),
        "company_id" => factory('App\Models\Company')->create(),
    ];
});

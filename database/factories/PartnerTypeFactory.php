<?php

$factory->define(App\PartnerType::class, function (Faker\Generator $faker) {
    return [
        "description" => $faker->name,
        "company_id" => factory('App\Models\Company')->create(),
    ];
});

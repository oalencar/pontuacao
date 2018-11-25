<?php

$factory->define(App\Partner::class, function (Faker\Generator $faker) {
    return [
        "company_id" => factory('App\Company')->create(),
        "user_id" => factory('App\User')->create(),
        "partner_type_id" => factory('App\PartnerType')->create(),
    ];
});

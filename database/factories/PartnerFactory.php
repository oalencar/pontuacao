<?php

$factory->define(App\Models\Partner::class, function (Faker\Generator $faker) {
    return [
        "company_id" => factory('App\Models\Company')->create(),
        "user_id" => factory('App\Models\User')->create(),
        "partner_type_id" => factory('App\Models\PartnerType')->create(),
    ];
});

<?php

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        "codigo" => $faker->name,
        "descricao" => $faker->name,
        "company_id" => factory('App\Models\Company')->create(),
        "client_id" => factory('\App\Models\Cliente')->create(),
    ];
});

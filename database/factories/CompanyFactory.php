<?php

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        "nome" => $faker->name,
        "endereco" => $faker->name,
        "telefone" => $faker->name,
    ];
});

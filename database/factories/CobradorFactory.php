<?php

use Faker\Generator as Faker;

$factory->define(App\Cobrador::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'paterno' => $faker->firstName,
        'materno' => $faker->lastName
    ];
});

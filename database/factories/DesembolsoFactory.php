<?php

use Faker\Generator as Faker;

$factory->define(App\Desembolso::class, function (Faker $faker) {
    return [
        'monto' => $faker->randomElement([10000,20000,30000,40000]),
        'fecha' => $faker->date,
        'prestario' => $faker->randomElement(['VICTOR', 'OMAR', 'EMPRESA'])
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\CorteDiario::class, function (Faker $faker) {
    return [
        'fecha' => $faker->date,
       // 'monto' => $faker->name,
        'id_usuario' => App\User::all()->random()->id
    ];
});

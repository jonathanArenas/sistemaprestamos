<?php

use Faker\Generator as Faker;

$factory->define(App\Cliente::class, function (Faker $faker) {
    return [
        'grupo_id' => App\Grupo::all()->random()->id,
        'nombre' => $faker->name,
        'paterno' => $faker->firstName,
        'materno' => $faker->lastName,
        'telefono' => $faker->randomElement(['0447671052389','0447671287563', '0456452315']),
        'direccion' => $faker->StreetAddress,
        'documento_I' => $faker->randomElement(['SI','NO']),
        'estatus' => $faker->randomElement( ['NUEVO', 'BAJA']),
        'reputacion' => rand(1,5)
    ];
});

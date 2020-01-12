<?php

use Faker\Generator as Faker;

$factory->define(App\CorteSemanal::class, function (Faker $faker) {
    return [
       'fecha' => $faker->date,
       //'monto' => ,
       'id_usuario' => App\User::all()->random()->id
    ];
});

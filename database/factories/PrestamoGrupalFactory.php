<?php

use Faker\Generator as Faker;

$factory->define(App\PrestamoGrupal::class, function (Faker $faker) {
    return [
        'fecha' => $faker->date,
        'id_grupo' => App\Grupo::All()->random()->id,
        'id_desembolso' => App\Desembolso::All()->random()->id
    ];
});

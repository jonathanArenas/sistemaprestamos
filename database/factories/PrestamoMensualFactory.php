<?php

use Faker\Generator as Faker;

$factory->define(App\PrestamoMensual::class, function (Faker $faker) {
	$mensualidad = $faker->randomElement([2,3,4,5,6,8,9,12]);
	$fechaDesde = $faker->date;
	$fechaHasta = date("Y-m-d", strtotime($fechaDesde."+ ".$mensualidad." month")); 
    return [
        'mensualidad' => $mensualidad,
        'porcentaje' => 10,
        'fecha_desde' =>$fechaDesde,
        'fecha_hasta' =>$fechaHasta,
        'id_desembolso' => App\Desembolso::All()->random()->id,
        'id_cliente' => App\Cliente::All()->random()->id,

    ];
});

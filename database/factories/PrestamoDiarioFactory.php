<?php

use Faker\Generator as Faker;

$factory->define(App\PrestamoDiario::class, function (Faker $faker) {
    return [
    	//'monto' => ,
    	//'interes' =>,
    	//'total_pagar',
        'fecha_desde' =>$fechaDesde,
        'fecha_hasta' =>$fechaHasta,
        'estatus' => $faker->randomElement(['OTORGANDO','PAGANDO','PAGADO']),
        //'id_desembolso' => ,
        //'id_cliente' => ,
    ];
});

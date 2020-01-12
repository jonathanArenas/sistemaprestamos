<?php

use Faker\Generator as Faker;

$factory->define(App\Grupo::class, function (Faker $faker) {

	$zona = $faker->state;
	$seccion = $faker->randomDigit;
    return [
       'id' => substr($zona, 0, 3).$seccion,
       'zona' => $zona,
       'seccion' => $seccion   
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Seccion::class, function (Faker $faker) {
    return [
       'id' => rand(1,5)
    ];
});

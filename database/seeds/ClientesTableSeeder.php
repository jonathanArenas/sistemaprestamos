<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(App\Cliente::class, 20)->create();
    }
}

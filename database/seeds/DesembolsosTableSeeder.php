<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DesembolsosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(App\Desembolso::class, 10)->create();
    }
}

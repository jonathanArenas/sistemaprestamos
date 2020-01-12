<?php

use Illuminate\Database\Seeder;

class PrestamosMensualesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PrestamoMensual::class, 5)->create();
    }
}

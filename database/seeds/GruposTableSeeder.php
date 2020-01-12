<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GruposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
     factory(App\Grupo::class,10)->create();
      
    }
}

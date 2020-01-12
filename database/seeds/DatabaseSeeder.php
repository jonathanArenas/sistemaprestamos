<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CapitalTableSeeder::class);
        //$this->call(GruposTableSeeder::class);
        //$this->call(ClientesTableSeeder::class);
        //$this->call(DesembolsosTableSeeder::class);
        //$this->call(PrestamosMensualesTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        $this->call(SeccionesTableSeeder::class);
        //$this->call()
    }
}

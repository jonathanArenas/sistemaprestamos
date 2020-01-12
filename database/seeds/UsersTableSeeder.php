<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'nombre' => 'Pedro',
        	'email' => 'ua@gmail.com',
        	'password' => bcrypt('1'),
        	'remember_token' => str_random(10)


        ]);
    }
}

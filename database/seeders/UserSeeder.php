<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon; 


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/UserTypeSeeder.php
    public function run()
    {   
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'Administrador',
                'email' => 'adm@gmail.com',
                'password' => Hash::make('12345@'),
                'user_type_id' => 1,
            ],
            [
                'name' => 'comum',
                'email' => 'common@gmail.com',
                'password' => Hash::make('123456'),
                'user_type_id' => 2,
            ],
        ]);
    }
}

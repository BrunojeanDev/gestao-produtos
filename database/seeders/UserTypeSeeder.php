<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; 

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {   
        $now = Carbon::now(); 

        DB::table('user_types')->insert([
            [
                'type' => 'administrador',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'comum',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

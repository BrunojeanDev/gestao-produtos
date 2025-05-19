<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; 

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   

        $now = Carbon::now(); 

        DB::table('permissions')->insert([
            [
                'name' => 'produtos',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'categorias',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'marcas',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

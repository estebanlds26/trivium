<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('producciones')->insert([
            [
                'fecha' => '2025-05-01',
                'cantidad' => 100,
                'user_id' => 1, // Replace with a valid user ID
                'producto_id' => 1, // Irish Red Ale
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-02',
                'cantidad' => 150,
                'user_id' => 1, // Replace with a valid user ID
                'producto_id' => 2, // Golden Ale
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-03',
                'cantidad' => 200,
                'user_id' => 1, // Replace with a valid user ID
                'producto_id' => 3, // Porter
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-04',
                'cantidad' => 120,
                'user_id' => 1,
                'producto_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-05',
                'cantidad' => 180,
                'user_id' => 1,
                'producto_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-06',
                'cantidad' => 220,
                'user_id' => 1,
                'producto_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-07',
                'cantidad' => 140,
                'user_id' => 1,
                'producto_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-08',
                'cantidad' => 160,
                'user_id' => 1,
                'producto_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-09',
                'cantidad' => 250,
                'user_id' => 1,
                'producto_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-10',
                'cantidad' => 130,
                'user_id' => 1,
                'producto_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

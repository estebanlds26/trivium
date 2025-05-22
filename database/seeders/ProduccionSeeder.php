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
                'active_step' => 0,
                'user_id' => 1, // Replace with a valid user ID
                'producto_id' => 1, // Irish Red Ale
                'proceso_id' => 1, // Add a valid proceso_id
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-02',
                'cantidad' => 150,
                'active_step' => 0,
                'user_id' => 1, // Replace with a valid user ID
                'producto_id' => 2, // Golden Ale
                'proceso_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-03',
                'cantidad' => 200,
                'active_step' => 0,
                'user_id' => 1, // Replace with a valid user ID
                'producto_id' => 3, // Porter
                'proceso_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-04',
                'cantidad' => 120,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 1,
                'proceso_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-05',
                'cantidad' => 180,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 2,
                'proceso_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-06',
                'cantidad' => 220,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 3,
                'proceso_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-07',
                'cantidad' => 140,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 1,
                'proceso_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-08',
                'cantidad' => 160,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 2,
                'proceso_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-09',
                'cantidad' => 250,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 3,
                'proceso_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-10',
                'cantidad' => 130,
                'active_step' => 0,
                'user_id' => 1,
                'producto_id' => 1,
                'proceso_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

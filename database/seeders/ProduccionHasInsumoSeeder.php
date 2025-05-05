<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduccionHasInsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('producciones_has_insumos')->insert([
            [
                'produccion_id' => 1,
                'insumo_id' => 1, // Replace with a valid insumo ID
                'cantidad_usada' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 1,
                'insumo_id' => 2,
                'cantidad_usada' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 2,
                'insumo_id' => 1,
                'cantidad_usada' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 2,
                'insumo_id' => 3,
                'cantidad_usada' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 3,
                'insumo_id' => 2,
                'cantidad_usada' => 70,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 3,
                'insumo_id' => 3,
                'cantidad_usada' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 4,
                'insumo_id' => 1,
                'cantidad_usada' => 55,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 5,
                'insumo_id' => 2,
                'cantidad_usada' => 65,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 6,
                'insumo_id' => 3,
                'cantidad_usada' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 7,
                'insumo_id' => 1,
                'cantidad_usada' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

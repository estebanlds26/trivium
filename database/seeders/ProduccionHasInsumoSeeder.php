<?php

namespace Database\Seeders;

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
                'insumo_id' => 1,
                'cantidad_usada' => 50,
                'precio_unitario' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 1,
                'insumo_id' => 2,
                'cantidad_usada' => 30,
                'precio_unitario' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 2,
                'insumo_id' => 1,
                'cantidad_usada' => 60,
                'precio_unitario' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 2,
                'insumo_id' => 3,
                'cantidad_usada' => 40,
                'precio_unitario' => 2500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 3,
                'insumo_id' => 2,
                'cantidad_usada' => 70,
                'precio_unitario' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 3,
                'insumo_id' => 3,
                'cantidad_usada' => 50,
                'precio_unitario' => 2500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 4,
                'insumo_id' => 1,
                'cantidad_usada' => 55,
                'precio_unitario' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 5,
                'insumo_id' => 2,
                'cantidad_usada' => 65,
                'precio_unitario' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 6,
                'insumo_id' => 3,
                'cantidad_usada' => 75,
                'precio_unitario' => 2500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'produccion_id' => 7,
                'insumo_id' => 1,
                'cantidad_usada' => 45,
                'precio_unitario' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntradaDeMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entrada_de_material')->insert([
            [
                'fecha' => '2025-05-01',
                'cantidad' => 50,
                'insumo_id' => 1, // Malta Pale Ale
                'precio_unitario' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-02',
                'cantidad' => 10,
                'insumo_id' => 2, // Lúpulo Cascade
                'precio_unitario' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => '2025-05-03',
                'cantidad' => 5,
                'insumo_id' => 3, // Levadura Ale
                'precio_unitario' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

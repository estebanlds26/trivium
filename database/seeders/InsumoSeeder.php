<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('insumos')->insert([
            [
                'nombre' => 'Malta Pale Ale',
                'unidad' => 25,
                'marca' => 'BrewMaster',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lúpulo Cascade',
                'unidad' => 5,
                'marca' => 'HopGrowers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Levadura Ale',
                'unidad' => 1,
                'marca' => 'YeastLab',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

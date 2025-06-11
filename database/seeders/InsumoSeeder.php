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
                'unidad' => 'libra',
                'marca' => 'BrewMaster',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lúpulo Cascade',
                'unidad' => 'gramo',
                'marca' => 'HopGrowers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Levadura Ale',
                'unidad' => 'gramo',
                'marca' => 'YeastLab',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

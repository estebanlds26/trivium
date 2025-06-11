<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            [ 'type' => 'simple', 'text' => 'Inicio' ],
            [ 'type' => 'checklist', 'text' => 'Se verifica la materia prima', 'items' => [
                ['insumo', false], ['insumo', false], ['insumo', false], ['insumo', false]
            ]],
            [ 'type' => 'simple', 'text' => 'Se pone a calentar el agua' ],
            [ 'type' => 'simple', 'text' => 'Molienda de la cebada' ],
            [ 'type' => 'simple', 'text' => 'Mezcla y macerado' ],
            [ 'type' => 'simple', 'text' => 'Extracción del mosto' ],
            [ 'type' => 'time', 'text' => 'Cocción', 'milliseconds' => 10000, 'startTime' => null, 'endTime' => null ],
            [ 'type' => 'simple', 'text' => 'Se le hecha lúpulo' ],
            [ 'type' => 'time', 'text' => 'Cocción', 'milliseconds' => 2700000, 'startTime' => null, 'endTime' => null ],
            [ 'type' => 'simple', 'text' => 'Se le hecha más lúpulo' ],
            [ 'type' => 'simple', 'text' => 'Whirlpool' ],
            [ 'type' => 'simple', 'text' => 'Enfriado' ],
            [ 'type' => 'time', 'text' => 'Fermentación', 'milliseconds' => 864000000, 'startTime' => null, 'endTime' => null ],
            [ 'type' => 'simple', 'text' => 'Enbarrilado' ],
            [ 'type' => 'time', 'text' => 'Reposo del enbarrilado', 'milliseconds' => 86400000, 'startTime' => null, 'endTime' => null ],
            [ 'type' => 'simple', 'text' => 'Gasificado' ],
            [ 'type' => 'time', 'text' => 'Reposo del gasificado', 'milliseconds' => 86400000, 'startTime' => null, 'endTime' => null ],
            [ 'type' => 'simple', 'text' => 'Enbotellado' ],
            [ 'type' => 'simple', 'text' => 'Fin' ],
        ];

        $beers = [
            [
                'nombre' => 'Irish Red Ale',
                'descripcion' => 'Proceso para Irish Red Ale',
                'insumos' => [
                    ['insumo_id' => 1, 'quantity' => 10],
                    ['insumo_id' => 2, 'quantity' => 5],
                ],
            ],
            [
                'nombre' => 'Golden Ale',
                'descripcion' => 'Proceso para Golden Ale',
                'insumos' => [
                    ['insumo_id' => 1, 'quantity' => 8],
                    ['insumo_id' => 3, 'quantity' => 7],
                ],
            ],
            [
                'nombre' => 'Porter',
                'descripcion' => 'Proceso para Porter',
                'insumos' => [
                    ['insumo_id' => 2, 'quantity' => 12],
                    ['insumo_id' => 3, 'quantity' => 6],
                ],
            ],
        ];

        foreach ($beers as $beer) {
            \App\Models\Proceso::create([
                'nombre' => $beer['nombre'],
                'descripcion' => $beer['descripcion'],
                'steps' => $steps,
                'insumos' => $beer['insumos'],
            ]);
        }
    }
}

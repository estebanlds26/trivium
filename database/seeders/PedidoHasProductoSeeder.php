<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoHasProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pedidos_has_productos')->insert([
            [
                'pedido_id' => 1,
                'producto_id' => 1, // Irish Red Ale
                'cantidad' => 10,
                'importe' => 90000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pedido_id' => 1,
                'producto_id' => 2, // Golden Ale
                'cantidad' => 5,
                'importe' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pedido_id' => 2,
                'producto_id' => 3, // Porter
                'cantidad' => 8,
                'importe' => 72000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pedido_id' => 3,
                'producto_id' => 1, // Irish Red Ale
                'cantidad' => 12,
                'importe' => 108000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

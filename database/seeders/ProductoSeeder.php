<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'nombre' => 'Irish Red Ale',
                'descripcion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
                'imagenes' => json_encode(['/images/welcome/TRIVIUM-25.jpg', '/images/welcome/TRIVIUM-28.jpg']),
                'precio' => 9000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Golden Ale',
                'descripcion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
                'imagenes' => json_encode(['/images/welcome/TRIVIUM-26.jpg', '/images/welcome/TRIVIUM-27.jpg']),
                'precio' => 9000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Porter',
                'descripcion' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
                'imagenes' => json_encode(['/images/welcome/TRIVIUM-29.jpg', '/images/welcome/TRIVIUM-30.jpg']),
                'precio' => 9000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

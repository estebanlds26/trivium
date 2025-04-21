<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nombre' => 'Admin',
                'descripcion' => 'Administrador con acceso total al sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cliente',
                'descripcion' => 'Cliente con acceso a la tienda y el contacto.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Trabajador',
                'descripcion' => 'Trabajador de Trivium con acceso a la tienda y el proceso de producción.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

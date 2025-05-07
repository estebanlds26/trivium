<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producciones_has_insumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produccion_id')->constrained('producciones')->onDelete('cascade');
            $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade');
            $table->integer('cantidad_usada');
            $table->integer('precio_unitario');
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['produccion_id', 'insumo_id']); // Esto va a evitar duplicados
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producciones_has_insumos');
    }
};

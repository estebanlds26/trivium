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
            $table->unsignedBigInteger('produccion_id');
            $table->unsignedBigInteger('insumo_id');
            $table->integer('cantidad_usada');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('produccion_id')->references('id')->on('producciones')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->unique(['produccion_id', 'insumo_id']); // Esto va a evitar duplicados
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producciones_has_insumos');
    }
};

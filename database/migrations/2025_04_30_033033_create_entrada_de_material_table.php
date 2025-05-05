<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('entrada_de_material', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('cantidad');
            $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade');
            $table->integer('precio_unitario');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('entrada_de_material');
    }
};

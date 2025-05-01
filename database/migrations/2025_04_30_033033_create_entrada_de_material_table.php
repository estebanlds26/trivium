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
            $table->unsignedBigInteger('insumos_id');
            $table->timestamps();

            // Clave foránea
            $table->foreign('insumos_id')->references('id')->on('insumos')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('entrada_de_material');
    }
};

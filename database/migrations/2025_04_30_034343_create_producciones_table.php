<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('producciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('cantidad');
            $table->unsignedBigInteger('productos_id');
            $table->unsignedBigInteger('productores_id');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('productos_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('productores_id')->references('id')->on('productores')->onDelete('cascade');
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('producciones');
    }
};

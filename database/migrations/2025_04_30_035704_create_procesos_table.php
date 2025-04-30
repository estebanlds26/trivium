<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fecha');
            $table->unsignedBigInteger('produccion_id');
            $table->timestamps();

            // Clave foránea
            $table->foreign('produccion_id')->references('id')->on('producciones')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};

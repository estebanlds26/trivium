<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('estado')->default('pendiente');
            $table->unsignedBigInteger('cliente_id');
            $table->timestamps();

            // Clave foránea
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};

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
            $table->enum('estado', ['Pendiente', 'En proceso', 'Completado', 'Cancelado'])->default('Pendiente');
            $table->integer("active_step")->default(0);
            $table->json("proceso_steps_copy")->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('proceso_id')->constrained('procesos')->onDelete('cascade');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('producciones');
    }
};

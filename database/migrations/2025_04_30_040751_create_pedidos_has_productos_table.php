<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos_has_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->integer('importe');
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['pedido_id', 'producto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos_has_productos');
    }
};

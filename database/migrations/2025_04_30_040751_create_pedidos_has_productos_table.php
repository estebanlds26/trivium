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
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            
            // Evitar duplicados
            $table->unique(['pedido_id', 'producto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos_has_productos');
    }
};

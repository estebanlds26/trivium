<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->unsignedBigInteger('insumos_id')->nullable();
            $table->unsignedBigInteger('productos_id')->nullable();
            $table->timestamps();

            //Claves foráneas
            $table->foreign('insumos_id')->references('id')->on('insumos')->onDelete('cascade');
            $table->foreign('productos_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

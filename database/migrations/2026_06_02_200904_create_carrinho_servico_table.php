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
        Schema::create('carrinho_servico', function (Blueprint $table) {
            $table->decimal('subtotal', total: 8, places: 2);
            $table->integer('quantidade');
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('servico_id');
            
            $table->foreign('pedido_id')->references('pedido_id')->on('pedido');
            $table->foreign('servico_id')->references('servico_id')->on('servico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinho_servico');
    }
};

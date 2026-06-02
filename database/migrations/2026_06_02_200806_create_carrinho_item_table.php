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
        Schema::create('carrinho_item', function (Blueprint $table) {
            $table->decimal('subtotal', total: 8, places: 2);
            $table->integer('quantidade');
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('item_id');
            
            $table->foreign('pedido_id')->references('pedido_id')->on('pedido');
            $table->foreign('item_id')->references('item_id')->on('item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinho_item');
    }
};

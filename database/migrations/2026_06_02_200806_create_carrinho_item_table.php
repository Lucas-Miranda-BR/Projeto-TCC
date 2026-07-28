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
            $table->id('carrinho_item_id');
            $table->decimal('subtotal', total: 8, places: 2);
            $table->integer('quantidade');
            $table->unsignedBigInteger('pedido_id')->default(0);
            $table->unsignedBigInteger('item_id')->default(0);
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            // $table->foreign('pedido_id')->references('pedido_id')->on('pedido')->restrictOnDelete();
            // $table->foreign('item_id')->references('item_id')->on('item')->restrictOnDelete();

            $table->unique(['pedido_id', 'item_id']);
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

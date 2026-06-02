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
            $table->foreignId('pedido_id')->constrained(
                table: 'pedido', indexName: 'pedido_id'
            );
            $table->foreignId('item_id')->constrained(
                table: 'item', indexName: 'item_id'
            );
            $table->decimal('subtotal', total: 8, places: 2);
            $table->integer('quantidade');
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

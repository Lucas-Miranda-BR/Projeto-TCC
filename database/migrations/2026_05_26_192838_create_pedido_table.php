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
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('pedido_id');
            $table->foreignId('cliente_id')->constrained(
                table: 'cliente', indexName: 'cliente_id'
            );
            $table->decimal('valor_total', total: 8, places: 2);
            $table->timestamp('pedido_data')->useCurrent();
            $table->string('forma_pagamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};

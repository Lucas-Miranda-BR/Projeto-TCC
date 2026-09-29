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
            $table->decimal('valor_total', total: 8, places: 2);
            $table->datetime('pedido_data')->useCurrent();
            $table->char('status', 1)->default("P");
            $table->decimal('valor_desconto', 10, 2)->default(0);
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('cliente_id')->references('cliente_id')->on('cliente')->restrictOnDelete();
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

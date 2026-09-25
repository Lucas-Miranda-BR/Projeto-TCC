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
        Schema::create('descontar_item', function (Blueprint $table) {
            $table->id('descontar_item_id');
            $table->unsignedBigInteger('desconto_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('desconto_id')->references('desconto_id')->on('desconto')->restrictOnDelete();
            $table->foreign('item_id')->references('item_id')->on('item')->restrictOnDelete();

            $table->unique(['desconto_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descontar_item');
    }
};

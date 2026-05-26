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
        Schema::create('item', function (Blueprint $table) {
            $table->id('item_id');
            $table->foreign('marca_id')->references('marca_id')->on('marca');
            $table->foreign('categoria_id')->references('categoria_id')->on('categoria');
            $table->string('nome');
            $table->decimal('preco', total: 8, places: 2);
            $table->integer('estoque');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item');
    }
};

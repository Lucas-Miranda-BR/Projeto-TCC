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
            $table->foreignId('marca_id')->constrained(
                table: 'marca', indexName: 'marca_id'
            );
            $table->foreignId('categoria_id')->constrained(
                table: 'categoria', indexName: 'categoria_id'
            );
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

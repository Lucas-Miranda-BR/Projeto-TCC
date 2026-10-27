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
            $table->string('nome');
            $table->decimal('preco', total: 8, places: 2);
            $table->integer('estoque');
            $table->string('foto');
            $table->string('descricao');
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('marca_id')->references('marca_id')->on('marca')->restrictOnDelete();
            $table->foreign('categoria_id')->references('categoria_id')->on('categoria')->restrictOnDelete();
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

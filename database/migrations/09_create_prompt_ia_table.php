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
        Schema::create('prompt_ia', function (Blueprint $table) {
            $table->id('prompt_ia_id');
            $table->string('imagem_prompt');
            $table->unsignedBigInteger('cliente_id')->default(0);
            $table->unsignedBigInteger('cor_unha_id')->default(0);
            $table->unsignedBigInteger('procedimento_id')->default(0);
            $table->unsignedBigInteger('cor_cabelo_id')->default(0);
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('cliente_id')->references('cliente_id')->on('cliente')->restrictOnDelete();
            $table->foreign('cor_unha_id')->references('cor_unha_id')->on('cor_unha')->restrictOnDelete();
            $table->foreign('procedimento_id')->references('procedimento_id')->on('procedimento')->restrictOnDelete();
            $table->foreign('cor_cabelo_id')->references('cor_cabelo_id')->on('cor_cabelo')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_ia');
    }
};

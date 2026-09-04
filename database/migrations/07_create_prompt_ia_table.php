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
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('cor_id')->nullable();
            $table->unsignedBigInteger('procedimento_id')->nullable();
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('cliente_id')->references('cliente_id')->on('cliente')->restrictOnDelete();
            $table->foreign('cor_id')->references('cor_id')->on('cor')->restrictOnDelete();
            $table->foreign('procedimento_id')->references('procedimento_id')->on('procedimento')->restrictOnDelete();
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

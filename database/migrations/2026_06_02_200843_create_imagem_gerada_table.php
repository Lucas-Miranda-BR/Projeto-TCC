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
        Schema::create('imagem_gerada', function (Blueprint $table) {
            $table->id('imagem_gerada_id');
            $table->string('imagem_gerada');
            $table->unsignedBigInteger('prompt_ia_id');
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('prompt_ia_id')->references('prompt_ia_id')->on('prompt_ia')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagem_gerada');
    }
};

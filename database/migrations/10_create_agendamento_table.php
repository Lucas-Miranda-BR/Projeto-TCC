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
        Schema::create('agendamento', function (Blueprint $table) {
            $table->id('agendamento_id');
            $table->time('hora');
            $table->date('data');
            $table->unsignedBigInteger('cliente_id')->default(0);
            $table->unsignedBigInteger('imagem_gerada_id')->default(0);
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('imagem_gerada_id')->references('imagem_gerada_id')->on('imagem_gerada')->restrictOnDelete();
            $table->foreign('cliente_id')->references('cliente_id')->on('cliente')->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamento');
    }
};

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
        Schema::create('servico', function (Blueprint $table) {
            $table->id('servico_id');
            $table->integer('imagem_gerada_id')->foreign()->references('imagem_gerada_id')->on('imagem_gerada');
            $table->string('tipo');
            $table->decimal('preco', total: 8, places: 2);
            $table->date('data_agendada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico');
    }
};

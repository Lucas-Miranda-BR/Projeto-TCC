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
            $table->foreignId('imagem_gerada_id')->constrained(
                table: 'imagem_gerada', indexName: 'imagem_gerada_id'
            );
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

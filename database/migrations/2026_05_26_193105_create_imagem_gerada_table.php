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
            $table->primary('imagem_gerada_id');
            $table->foreignId('prompt_ia_id')->constrained(
                table: 'prompt_ia', indexName: 'prompt_ia_id'
            );
            $table->string('imagem_gerada');
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

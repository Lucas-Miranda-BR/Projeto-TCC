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
        Schema::create('notificacao', function (Blueprint $table) {
            $table->primary('notificacao_id');
            $table->foreignId('cliente_id')->constrained(
                table: 'cliente', indexName: 'cliente_id'
            );
            $table->string('titulo');
            $table->string('conteudo');
            $table->timestamp('data_recebida')->useCurrent();
            $table->boolean('visualizada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacao');
    }
};

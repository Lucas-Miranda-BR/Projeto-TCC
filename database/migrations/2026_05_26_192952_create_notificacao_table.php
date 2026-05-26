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
            $table->id('notificacao_id');
            $table->foreign('cliente_id')->references('cliente_id')->on('cliente');
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

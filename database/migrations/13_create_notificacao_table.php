<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notificacao')) {

            Schema::create('notificacao', function (Blueprint $table) {

                $table->id('notificacao_id');
                $table->string('titulo');
                $table->string('conteudo');
                $table->timestamp('data_recebida')->useCurrent();
                $table->boolean('visualizada')->default(false);
                $table->timestamp('criado')->useCurrent();
                $table->unsignedBigInteger('cliente_id')->nullable();
                $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

                $table->foreign('cliente_id')->references('cliente_id')->on('cliente')->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacao');
    }
};
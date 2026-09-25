<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('template_notificacao')) {

            Schema::create('template_notificacao', function (Blueprint $table) {

                $table->id('template_notificacao_id');
                $table->string('titulo');
                $table->string('conteudo');
                $table->string('tipo');
                $table->timestamp('criado')->useCurrent();
                $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('template_notificacao');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedimento', function (Blueprint $table) {
            $table->id('procedimento_id');

            $table->string('nome');

            $table->string('descricao');

            $table->string('imagem')->nullable();

            $table->decimal('preco', 8, 2);

            $table->unsignedBigInteger('tipo_id')->nullable();

            $table->timestamp('criado')
                ->useCurrent();

            $table->timestamp('atualizado')
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign('tipo_id')
                ->references('tipo_id')
                ->on('tipo')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedimento');
    }
};
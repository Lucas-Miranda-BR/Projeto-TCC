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
        Schema::create('procedimento', function (Blueprint $table) {
            $table->id('procedimento_id');
            $table->string('nome');
            $table->string('descricao');
            $table->string('imagem')->nullable();
            $table->decimal('preco', total: 8, places: 2);
            $table->unsignedBigInteger('tipo_id')->nullabe();
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('tipo_id')->references('tipo_id')->on('tipo')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedimento');
    }
};

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
            $table->decimal('total', total: 8, places: 2);
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('agendamento_id')->nullable();

            $table->foreign('agendamento_id')->references('agendamento_id')->on('agendamento')->restrictOnDelete();
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

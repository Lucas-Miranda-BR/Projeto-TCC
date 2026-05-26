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
        Schema::create('cliente', function (Blueprint $table) {
            $table->primary('cliente_id');
            $table->foreignId('estado_id')->constrained(
                table: 'estado', indexName: 'estado_id'
            );
            $table->foreignId('cidade_id')->constrained(
                table: 'cidade', indexName: 'cidade_id'
            );
            $table->string('nome');
            $table->string('sobrenome');
            $table->unique('cpf');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('endereco');
            $table->date('data_nascimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};

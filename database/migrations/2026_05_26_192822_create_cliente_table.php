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
            $table->id('cliente_id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf')->unique();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('endereco');
            $table->date('data_nascimento');
            $table->foreignId('estado_id')->constrained(
                table: 'estado', indexName: 'estado_id'
            );
            $table->foreignId('cidade_id')->constrained(
                table: 'cidade', indexName: 'cidade_id'
            );
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

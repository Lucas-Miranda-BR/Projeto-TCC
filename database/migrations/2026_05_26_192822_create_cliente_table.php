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
            $table->integer('estado_id')->foreign()->references('estado_id')->on('estado');
            $table->integer('cidade_id')->foreign()->references('cidade_id')->on('cidade');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf')->unique();
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

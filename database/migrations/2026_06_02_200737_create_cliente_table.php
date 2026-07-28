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
            $table->string('email')->nullable()->unique();
            $table->string('endereco');
            $table->date('data_nascimento');
            $table->string('senha');
            $table->boolean('admin')->default(false);
            $table->unsignedBigInteger('estado_id')->default(0);
            $table->unsignedBigInteger('cidade_id')->default(0);
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();

           // $table->foreign('estado_id')->references('estado_id')->on('estado')->restrictOnDelete();
            // $table->foreign('cidade_id')->references('cidade_id')->on('cidade')->restrictOnDelete();
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

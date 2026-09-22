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
        Schema::create('networth', function (Blueprint $table) {
            $table->id('networth_id');
            $table->decimal('ganho', total:10, places:2)->default(0);
            $table->decimal('custo', total:10, places:2)->default(0);
            $table->decimal('networth', total:10, places:2)->default(0);
            $table->date('dia')->useCurrent();
            $table->integer('hora');
            $table->timestamp('criado')->useCurrent();
            $table->timestamp('atualizado')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('networth');
    }
};

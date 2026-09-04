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
            $table->decimal('ganho', total:8, places:2);
            $table->decimal('custo', total:8, places:2);
            $table->decimal('networth', total:8, places:2);
            $table->date('dia');
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

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
        Schema::create('pistas', function (Blueprint $table) {
            $table->id('id_pista');
            $table->string("estado");
            $table->date("fecha");
            $table->time("hora_inicio");//->nullable() puede ser null
            $table->time("hora_fin");//->unique() no se puede repetir
            $table->integer("id_pista");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pistas');
    }
};

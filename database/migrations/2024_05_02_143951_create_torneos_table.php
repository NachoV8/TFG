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
        Schema::create('torneos', function (Blueprint $table) {
            $table->id('id_torneo');
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('precio');
            $table->integer('cant_max');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('id_pista');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('torneos');
    }
};

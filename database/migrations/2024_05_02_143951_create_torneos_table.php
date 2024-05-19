<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->increments('id_torneo');
            $table->string('nombre', 80);
            $table->string('descripcion', 200);
            $table->string('premios', 200);
            $table->smallInteger('precio');
            $table->integer('cant_max')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->unsignedInteger('id_pista')->nullable();

            // Foreign key
            $table->foreign('id_pista')->references('id_pista')->on('pistas')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('torneos', function (Blueprint $table) {
            $table->dropForeign(['id_pista']);
        });

        Schema::dropIfExists('torneos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePistasTable extends Migration
{
    public function up()
    {
        Schema::create('pistas', function (Blueprint $table) {
            $table->increments('id_pista');
            $table->tinyInteger('pista');
            $table->tinyInteger('estado')->default(0);
            $table->date('fecha')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->unsignedInteger('id_usuario')->nullable();

            // Foreign key
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pistas', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });

        Schema::dropIfExists('pistas');
    }
}

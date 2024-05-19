<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorneoParticipantesTable extends Migration
{
    public function up()
    {
        Schema::create('torneo_participantes', function (Blueprint $table) {
            $table->unsignedInteger('id_torneo');
            $table->unsignedInteger('id_usuario');

            // Primary key
            $table->primary(['id_torneo', 'id_usuario']);

            // Foreign keys
            $table->foreign('id_torneo')->references('id_torneo')->on('torneos')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('torneo_participantes', function (Blueprint $table) {
            $table->dropForeign(['id_torneo']);
            $table->dropForeign(['id_usuario']);
        });

        Schema::dropIfExists('torneo_participantes');
    }
}

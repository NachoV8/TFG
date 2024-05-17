<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration
{
    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->increments('id_clase');
            $table->unsignedInteger('id_profesor');
            $table->unsignedInteger('id_pista');
            $table->unsignedInteger('id_alumno')->nullable();
            $table->string('descripcion', 200);
            $table->smallInteger('precio');
            $table->time('hora_inicio')->nullable();
            $table->date('fecha')->nullable();

            // Foreign keys
            $table->foreign('id_profesor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pista')->references('id_pista')->on('pistas')->onDelete('cascade');
            $table->foreign('id_alumno')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('clases', function (Blueprint $table) {
            $table->dropForeign(['id_profesor']);
            $table->dropForeign(['id_pista']);
            $table->dropForeign(['id_alumno']);
        });

        Schema::dropIfExists('clases');
    }
}

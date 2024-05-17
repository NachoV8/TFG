<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->string('nombre', 80);
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('tipo', 60);
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}

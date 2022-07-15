<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcategoria')->unsigned();//fk
            $table->integer('idgramaje')->unsigned();//fk */
            $table->string('nombre', 100)->unique();
            $table->string('concentracion', 30);
            $table->string('administracion', 30);
            $table->string('presentacion', 50)->nullable();
            $table->string('items', 256)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            //para la relacion de la llave foranea
            $table->foreign('idcategoria')->references('id')->on('categorias');
            $table->foreign('idgramaje')->references('id')->on('gramajes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}

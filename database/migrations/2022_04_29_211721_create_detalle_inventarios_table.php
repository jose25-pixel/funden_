<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_inventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idinventarios')->unsigned();//fk
            $table->integer('c_antiguo_blister');
            $table->integer('c_antiguo_tableta');
            $table->timestamps();


            $table->foreign('idinventarios')->references('id')->on('inventarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_inventarios');
    }
}

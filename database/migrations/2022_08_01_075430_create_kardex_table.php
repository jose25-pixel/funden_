<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->increments('id_kardex');
            $table->integer('iddetalleingreso')->unsigned();
            $table->foreign('iddetalleingreso')->references('id')->on('detalle_ingresos')->onDelete('cascade');
            $table->integer('iddetalleinventario')->unsigned();
            $table->foreign('iddetalleinventario')->references('id')->on('detalle_inventarios');
            $table->string('acciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex');
    }
}

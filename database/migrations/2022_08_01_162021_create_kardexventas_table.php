<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardexventas', function (Blueprint $table) {
            $table->increments('id_kardexventas');
            $table->integer('iddetalleventa')->unsigned();
            $table->foreign('iddetalleventa')->references('id')->on('detalle_ventas')->onDelete('cascade');
            $table->integer('iddetalleinventariov')->unsigned();
            $table->foreign('iddetalleinventariov')->references('id')->on('detalle_inventarios');
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
        Schema::dropIfExists('kardexventas');
    }
}

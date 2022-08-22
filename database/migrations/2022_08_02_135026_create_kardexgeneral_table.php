<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexgeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardexgeneral', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idkardexI')->unsigned();
            $table->foreign('idkardexI')->references('id_kardex')->on('kardex')->onDelete('cascade');
            $table->integer('idkardexV')->unsigned();
            $table->foreign('idkardexV')->references('id_kardexventas')->on('kardexventas');
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
        Schema::dropIfExists('kardexgeneral');
    }
}

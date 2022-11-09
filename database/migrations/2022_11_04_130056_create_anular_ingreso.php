<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnularIngreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER  `anularingreso` AFTER UPDATE ON `ingresos` FOR EACH ROW BEGIN UPDATE
         inventarios i JOIN detalle_ingresos di ON di.idinventario =i.id
          AND di.idingreso = NEW.id SET i.cantidad_tableta = i.cantidad_tableta - di.cantidad,
        i.cantidad_blister=i.cantidad_blister -di.cantidad_blister; end
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

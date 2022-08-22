<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER `stock_salidad` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
        UPDATE inventarios SET cantidad_tableta = cantidad_tableta - NEW.cantidad,
        cantidad_blister = cantidad_blister - NEW.cantidad_blister
        WHERE inventarios.id = NEW.idinventario;
        END

');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `stock_salidad`');
    }
}

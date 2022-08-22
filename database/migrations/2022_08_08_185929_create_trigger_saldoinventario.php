<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerSaldoinventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER `stock_antiguo` AFTER UPDATE ON `inventarios` FOR EACH ROW INSERT into detalle_inventarios(antiguo_tableta,antiguo_blister,idinventarios)VALUES
        (NEW.cantidad_tableta,NEW.cantidad_blister,NEW.id)
');

        


 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `stock_antiguo`');
    }
}

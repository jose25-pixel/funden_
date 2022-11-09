<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnularVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared('
CREATE TRIGGER `anulaventa` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN UPDATE inventarios 
i JOIN detalle_ventas dv ON dv.idinventario =i.id AND dv.idventa = NEW.id SET i.cantidad_tableta = i.cantidad_tableta + dv.cantidad,
 i.cantidad_blister=i.cantidad_blister + dv.cantidad_blister; end
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

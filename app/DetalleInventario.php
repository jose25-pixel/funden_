<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleInventario extends Model
{
    protected $table = 'detalle_inventarios';
    protected  $fillable=[
        'idinventarios',
        'antiguo_tableta',
        'antiguo_blister'
        ];

        public $timestamps = false;
}

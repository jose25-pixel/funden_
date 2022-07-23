<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
  protected $fillable=[
    'dcliente',
    'idusuario',
    'fecha_salida',
    'total',
    'estado'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kardex extends Model
{
    protected $table = 'kardex';
    protected  $fillable=[
        'iddetalleingreso',
        'iddetalleinventario',
        'acciones'
        ];

       // public $timestamps = false;
}

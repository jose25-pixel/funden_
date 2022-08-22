<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kardexxv extends Model
{
    protected $table = 'kardexventas';
    protected  $fillable=[
        'iddetalleventa',
        'iddetalleinventariov',
        'acciones'
    ];
}

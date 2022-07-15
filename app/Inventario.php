<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable = [
        'idproducto','cantidad_tableta','cantidad_blister'
    ];


//por la relacion con articulos
public function articulo(){
    return $this->belongsTo('App\articulo');
}

}

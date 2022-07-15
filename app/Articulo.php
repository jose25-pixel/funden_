<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    //
    protected $fillable = [
        'idcategoria','nombre','concentracion','administracion','presentacion','items', 'condicion'
    ];

    //por la relacion con categoria
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }

}

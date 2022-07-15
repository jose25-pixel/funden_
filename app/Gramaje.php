<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gramaje extends Model
{
    protected $fillable = ['nombre', 'condicion'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}

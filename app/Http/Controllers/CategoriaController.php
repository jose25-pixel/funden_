<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Categoria;
class CategoriaController extends Controller
{
   
    //Función para mostrar los registros de casa farmacéuticas.
    public function index( Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $categorias = Categoria::orderBy('id','desc')->paginate(12);
        }
        else{
            $categorias = Categoria::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id','desc')->paginate(12);
        }
        return[
            'pagination' =>[
                'total' => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page' => $categorias->perPage(),
                'last_page' => $categorias->lastPage(),
                'from' => $categorias->firstItem(),
                'to' => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }

    //Función para seleccionar la casa farmacéutica.
    public function selectCategoria(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion', '=', '1')
        ->select('id','nombre')
        ->orderBy('nombre','asc')
        ->get();
        return ['categorias' => $categorias];
    }

    //Función para ingresar
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $categoria = new Categoria();
        //tomar los datos de request
        $categoria->nombre = $request->nombre;
        $categoria->condicion = 1; //activo
        //guardar el objeto en la tabla
        $categoria->save();
    }

    //Acttuarlizar registros
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $categoria =  Categoria::findOrfail($request->id);

        //tomar los datos de request
        $categoria->nombre = $request->nombre;
        $categoria->condicion = 1; //activo

        //guardar el objeto en la tabla
        $categoria->save();
    }

   //Función para desactivar un registro.
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $categoria =  Categoria::findOrfail($request->id);
        //cambiar la condicion a 0
        $categoria->condicion = 0; //desactivo
        //guardar el objeto en la tabla
        $categoria->save();
    }

    //Función para activar un registro.
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          //buscar la categoria por el $id del request
          $categoria =  Categoria::findOrfail($request->id);
          //cambiar la condicion a 1
          $categoria->condicion = 1; //activo
          //guardar el objeto en la tabla
          $categoria->save();
    }

}
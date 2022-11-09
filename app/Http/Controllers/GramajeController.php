<?php

namespace App\Http\Controllers;

use App\Gramaje;
use Illuminate\Http\Request;

class GramajeController extends Controller
{

    //Función para mostrar todos los registros de gramaje.
    public function index( Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
                $gramajes = Gramaje::orderBy('id','desc')
                ->paginate(12);
        }
            else{
                $gramajes = Gramaje::where($criterio, 'like', '%'. $buscar . '%')
                ->orderBy('id','desc')
                ->paginate(12);
        }
        return[
            'pagination' =>[
                'total' => $gramajes->total(),
                'current_page' => $gramajes->currentPage(),
                'per_page' => $gramajes->perPage(),
                'last_page' => $gramajes->lastPage(),
                'from' => $gramajes->firstItem(),
                'to' => $gramajes->lastItem(),
            ],
            'gramajes' => $gramajes
        ];
    }
 
    //Función para ingresar un registro.
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $gramaje = new Gramaje();
        //tomar los datos de request
        $gramaje->gramaje = $request->gramaje;
        $gramaje->condicion = 1; //activo
        //guardar el objeto en la tabla
        $gramaje->save();
    }

    //Función para actualizar registro.
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $gramaje =  Gramaje::findOrfail($request->id);
        //tomar los datos de request
        $gramaje->gramaje = $request->gramaje;
        $gramaje->condicion = 1; //activo
        //guardar el objeto en la tabla
        $gramaje->save();
    }

    //Función para desactivar un registro.
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la gramaje por el $id del request
        $gramaje =  Gramaje::findOrfail($request->id);
        //cambiar la condicion a 0
        $gramaje->condicion = 0; //desactivo
        //guardar el objeto en la tabla
        $gramaje->save();
    }

    //Función para activar un registro
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          //buscar la gramaje por el $id del request
          $gramaje =  Gramaje::findOrfail($request->id);
          //cambiar la condicion a 1
          $gramaje->condicion = 1; //activo
          //guardar el objeto en la tabla
          $gramaje->save();
    }

     /* Función para selecionar  gramaje al momento de selecionar medicamento */
    public function selectGramaje(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $gramajes = Gramaje::where('condicion', '=', '1')
        ->select('id','gramaje')
        ->orderBy('gramaje','asc')
        ->get();
        return ['gramajes' => $gramajes];
    } 
}

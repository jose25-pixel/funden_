<?php

namespace App\Http\Controllers;

use App\Gramaje;
use Illuminate\Http\Request;

class GramajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $gramajes = Gramaje::orderBy('id','desc')->paginate(3);
        }
        else{
            $gramajes = Gramaje::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(3);
        }
        //listar todos los registros
       // $categorias = Categoria::paginate(3);
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

    public function selectGramaje(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $gramajes = Gramaje::where('condicion', '=', '1')
        ->select('id','gramaje')->orderBy('gramaje','asc')->get();

        return ['gramajes' => $gramajes];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario;


class InventarioController extends Controller
{
    /*funcion para mostrar datos de la tabla de inventarios*/
    
    public function index(Request $request)
    {
         if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar == '') {
            $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('inventarios.id','inventarios.idproducto',
                    'articulos.nombre as medicamento','articulos.concentracion','articulos.presentacion','articulos.administracion',
                    'articulos.items',
                    'categorias.nombre as casa_farmaceutica',
                     'gramajes.gramaje as gramaje',
                    'inventarios.cantidad_blister','inventarios.cantidad_tableta','articulos.condicion',
                )->orderBy('articulos.id', 'desc')->paginate(12);
        } else {
            $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id',)
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('inventarios.id','inventarios.idproducto',
                'articulos.nombre as medicamento','articulos.concentracion','articulos.presentacion','articulos.administracion',
                'articulos.items',
                'categorias.nombre as casa_farmaceutica',
                 'gramajes.gramaje as gramaje',
                'inventarios.cantidad_blister','inventarios.cantidad_tableta','articulos.condicion',)
                ->where('inventarios.' . $criterio, 'like', '%' . $buscar . '%')->orderBy('articulos.id', 'desc')->paginate(12);
        }
        return [
            'pagination' => [
                'total' => $inventarios->total(),
                'current_page' => $inventarios->currentPage(),
                'per_page' => $inventarios->perPage(),
                'last_page' => $inventarios->lastPage(),
                'from' => $inventarios->firstItem(),
                'to' => $inventarios->lastItem(),
            ],
            'inventarios' => $inventarios
        ];
    }
        /*funcion para mostrar datos del medicamento al momento de realizar nuevo ingreso*/

    public function listarArticuloinventario(Request $request)
    {
         //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $inventarios = Inventario::join('articulos','inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  
            'articulos.concentracion','articulos.administracion','articulos.presentacion','articulos.items',
            'inventarios.cantidad_tableta','inventarios.cantidad_blister','articulos.condicion')
            ->where('articulos.condicion','=','1')
            ->orderBy('articulos.id','desc')->paginate(7);
        }
        else{
            $inventarios = Inventario::join('articulos','inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje', 
            'articulos.concentracion','articulos.administracion', 'articulos.presentacion','articulos.items','inventarios.cantidad_tableta',
            'inventarios.cantidad_blister',  'articulos.condicion'
            )->where('articulos.'.$criterio,'like','%'.$buscar.'%')
            ->where('articulos.condicion','=','1')
            ->orderBy('articulos.id','desc')->paginate(7);
        }
        return['inventarios' => $inventarios]; 
    }

    /*Función para listar medicamentos del inventario para vender con stock mayor a cero */
    public function listarArticuloinventarioV(Request $request)
    {
         //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $inventarios = Inventario::join('articulos','inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  
            'articulos.concentracion','articulos.administracion','articulos.presentacion','articulos.items','inventarios.cantidad_tableta',
            'inventarios.cantidad_blister','articulos.condicion') 
            ->where('cantidad_tableta', '>', '0')
            ->where('articulos.condicion', '=', '1')
            ->orderBy('articulos.id','desc')->paginate(7);
        }
        else{
            $inventarios = Inventario::join('articulos','inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',
            'articulos.concentracion','articulos.administracion', 'articulos.presentacion','articulos.items','inventarios.cantidad_tableta',
            'inventarios.cantidad_blister','articulos.condicion'
            ) ->where('cantidad_tableta', '>', '0')
            ->where('articulos.'.$criterio,'like','%'.$buscar.'%')
            ->where('articulos.condicion', '=', '1')
            ->orderBy('articulos.id','desc')->paginate(7);
        }
        return['inventarios' => $inventarios]; 
    }
    
 
    //Función del reporte de todos los productos
    public function inventarioPdf() 
    {
            $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('inventarios.id','inventarios.idproducto',
                    'articulos.nombre as medicamento','articulos.concentracion','articulos.presentacion','articulos.administracion',
                    'articulos.items',
                    'categorias.nombre as casa_farmaceutica',
                     'gramajes.gramaje as gramaje',
                    'inventarios.cantidad_blister','inventarios.cantidad_tableta','inventarios.condicion')
                    ->orderBy('articulos.id', 'desc')
                    ->get();

        $cont=Inventario::count();
        $pdf = \PDF::loadView('pdf.inventariopdf',['inventarios'=>$inventarios, 'cont' => $cont]);

        return $pdf
        ->setPaper('carta', 'landscape')
        ->stream('Inventario-'.now().'.pdf');
    }



       /* ++++ no se utiiza en el codigo ++++  Función para buscar medicamentos por nombre */
       public function buscarArticuloInventario(Request $request){
        $filtro = $request->filtro;
        $inventarios = Inventario::join('articulos','inventarios.idproducto','=','articulos.id')
        ->where('articulos.nombre', '=', $filtro)
        ->select('inventarios.id','articulos.nombre','articulos.presentacion')
        ->where('cantidad_tableta', '>', '0')->take(1)->get();
        return ['inventarios' => $inventarios];  
    }

    /*  ++++ no se utiiza en el codigo ++++  Función para buscar medicamentos en invetarios con stock mayor a cero para vender*/
    public function buscarInventarioVenta(Request $request)
    {

        //if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $inventarios = Inventario::join('articulos','inventarios.idproducto','=','articulos.id')
        ->where('articulos.nombre', '=', $filtro)
        ->select('inventarios.id','articulos.nombre','inventarios.cantidad_tableta')
        ->where('cantidad_tableta', '>', '0')->take(1)->get();
        
        return ['inventarios' => $inventarios];  

       
    }

   /*Función para actualizar inventario ++++ no se utiiza en el codigo ++++*/
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $inventarios =  Inventario::findOrfail($request->id);
        //tomar los datos de request
        $inventarios->idarticulo = $request->idarticulo;
        $inventarios->stock_b = $request->stock_b;
        $inventarios->stock_t = $request->stock_t;
        $inventarios->save();
        
    }

    /* ++++ no se utiiza en el codigo ++++ funcion para ingresar inventario*/
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inventarios = new Inventario();
        $inventarios->idproducto = $request->idproducto;
        $inventarios->cantidad_tableta ='0'; //$request->cantidad_tableta;
        $inventarios->cantidad_blister = '0';//$request->cantidad_blister;
        $inventarios->condicion = '1';
        $inventarios->save();
    }

}

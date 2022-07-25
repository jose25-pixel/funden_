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
                ->select(
                    'inventarios.id',
                    'inventarios.idproducto',
                    'articulos.nombre as nombre_articulo',
                    'inventarios.cantidad_blister',
                    'inventarios.cantidad_tableta',
                    'inventarios.condicion',
                )->orderBy('articulos.id', 'desc')->paginate(8);
        } else {
            $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id',)
                ->select(
                    'inventarios.id',
                    'inventarios.idproducto',
                    'articulos.nombre as nombre_articulo',
                    'inventarios.cantidad_blister',
                    'inventarios.cantidad_tableta',
                )->where('inventarios.' . $criterio, 'like', '%' . $buscar . '%')->orderBy('articulos.id', 'desc')->paginate(8);
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
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion','articulos.presentacion','inventarios.cantidad_tableta','inventarios.cantidad_blister','articulos.condicion'
            )->orderBy('articulos.id','desc')->paginate(10);
        }
        else{
            $inventarios = Inventario::join('articulos','inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion', 'articulos.presentacion','inventarios.cantidad_tableta','inventarios.cantidad_blister','articulos.condicion'
            )->where('articulos.'.$criterio,'like','%'.$buscar.'%')->orderBy('articulos.id','desc')->paginate(10);
        }
        return['inventarios' => $inventarios]; 
    }
/*funcion para listar medicamentos del inventario para vender con stock mayor a cero */
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
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion','articulos.presentacion','inventarios.cantidad_tableta','inventarios.cantidad_blister','articulos.condicion'
            ) ->where('cantidad_tableta', '>', '0')->orderBy('articulos.id','desc')->paginate(10);
        }
        else{
            $inventarios = Inventario::join('articulos','inventarios.idproducto', '=', 'articulos.id')
            ->join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion', 'articulos.presentacion','inventarios.cantidad_tableta','inventarios.cantidad_blister','articulos.condicion'
            ) ->where('cantidad_tableta', '>', '0')
            ->where('articulos.'.$criterio,'like','%'.$buscar.'%')->orderBy('articulos.id','desc')->paginate(10);
        }
        return['inventarios' => $inventarios]; 
    }
/*funcion para buscar medicamentos en invetarios */

    public function buscarArticuloInventario(Request $request){
        $filtro = $request->filtro;
        $inventarios = Inventario::join('articulos','inventarios.idproducto','=','articulos.id')
        ->where('articulos.nombre', '=', $filtro)
        ->select('inventarios.id','articulos.nombre',)
        ->where('cantidad_tableta', '>', '0')->take(1)->get();
        return ['inventarios' => $inventarios];  
    }

    /*funcion para buscar medicamentos en invetarios con stock mayor a cero para vender*/

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
/*funcion para actualizar inventario*/
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
    /*funcion para ingresar inventario*/

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

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $inventarios=  Inventario::findOrfail($request->id);

        //cambiar la condicion a 0
        $inventarios->condicion = '0'; //desactivo

        //guardar el objeto en la tabla
        $inventarios->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $articulo =  Inventario::findOrfail($request->id);

        //cambiar la condicion a 1
        $articulo->condicion = '1'; //activo

        //guardar el objeto en la tabla
        $articulo->save();
    }

}

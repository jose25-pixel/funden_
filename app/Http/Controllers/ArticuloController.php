<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Inventario;
use App\DetalleInventario;
use App\Ingreso;
use App\DetalleIngreso;

class ArticuloController extends Controller
{

  public function indexprueva(Request $request)
    {
      //  if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
           // $articulo =  Articulo::findOrfail($request->id);
            //tomar los datos de request
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
                ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
                ->join('inventarios', 'inventarios.idproducto', '=', 'inventarios.id')
                ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.idgramaje',
                    'articulos.nombre',
                    'gramajes.gramaje as nombre_gramaje',
                    'categorias.nombre as nombre_categoria',
                    'articulos.concentracion',
                    'articulos.administracion',
                    'articulos.presentacion',
                    'articulos.items',
                    'articulos.condicion',
                    'inventarios.cantidad_tableta'
                )->orderBy('articulos.id', 'desc')->paginate(8);
        } else {
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id',)
                ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
                ->join('inventarios', 'inventarios.idproducto', '=', 'inventarios.id')
                ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.idgramaje',
                    'articulos.nombre',
                    'gramajes.gramaje as nombre_gramaje',
                    'categorias.nombre as nombre_categoria',
                    'articulos.concentracion',
                    'articulos.administracion',
                    'articulos.presentacion',
                    'articulos.items',
                    'articulos.condicion'
                )->where('articulos.' . $criterio, 'like', '%' . $buscar . '%')->orderBy('articulos.id', 'desc')->paginate(8);
        }

        return [ 'articulos' => $articulos];
    }


    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
                ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
                ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.idgramaje',
                    'articulos.nombre',
                    'gramajes.gramaje as nombre_gramaje',
                    'categorias.nombre as nombre_categoria',
                    'articulos.concentracion',
                    'articulos.administracion',
                    'articulos.presentacion',
                    'articulos.items',
                    'articulos.condicion'
                )->orderBy('articulos.id', 'desc')->paginate(8);
        } else {
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id',)
                ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
                ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.idgramaje',
                    'articulos.nombre',
                    'gramajes.gramaje as nombre_gramaje',
                    'categorias.nombre as nombre_categoria',
                    'articulos.concentracion',
                    'articulos.administracion',
                    'articulos.presentacion',
                    'articulos.items',
                    'articulos.condicion'
                )->where('articulos.' . $criterio, 'like', '%' . $buscar . '%')->orderBy('articulos.id', 'desc')->paginate(8);
        }

        /* if($buscar==''){
            $articulos = Articulo::join('gramajes','articulos.idgramaje', '=', 'gramajes.id')->select(
                'articulos.id','articulos.idgramaje',
            )->orderBy('articulos.id','desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('gramajes','articulos.idgramaje', '=', 'gramajes.id')->select(
                'articulos.id','articulos.idgramaje',
            )->where('articulos.'.$criterio,'like','%'.$buscar.'%')->orderBy('articulos.id','desc')->paginate(10);
        } */
        //listar todos los registros
        // $categorias = Categoria::paginate(3);
        return [
            'pagination' => [
                'total' => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page' => $articulos->perPage(),
                'last_page' => $articulos->lastPage(),
                'from' => $articulos->firstItem(),
                'to' => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

   

    public function listarPdf()
    {
        $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->select(
                'articulos.id',
                'articulos.idcategoria',
                'articulos.codigo',
                'articulos.nombre',
                'categorias.nombre as nombre_categoria',
                'articulos.precio_venta',
                'articulos.stock',
                'articulos.descripcion',
                'articulos.condicion'
            )->where('articulos.stock', '>', '0')
            ->orderBy('articulos.id', 'desc')->get();

        $cont = Articulo::count();
        $pdf = \PDF::loadView('pdf.articulospdf', ['articulos' => $articulos, 'cont' => $cont]);
        return $pdf->download('articulos.pdf');
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $articulo = new Articulo();
        //tomar los datos de request
        $articulo->idcategoria = $request->idcategoria;
        $articulo->idgramaje = $request->idgramaje;
        $articulo->nombre = $request->nombre;
        $articulo->concentracion = $request->concentracion;
        $articulo->administracion = $request->administracion;
        $articulo->presentacion = $request->presentacion;
        $articulo->items = $request->items;
        $articulo->condicion = '1'; //activo
        //guardar el objeto en la tabla
        $articulo->save();
       // return $articulo->id;



        $inventarios = new Inventario();
        $inventarios->idproducto = $articulo->id;
        $inventarios->cantidad_tableta ='0'; //$request->cantidad_tableta;
        $inventarios->cantidad_blister = '0';//$request->cantidad_blister;
        $inventarios->condicion = '1';
        $inventarios->save();




    }



    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $articulo =  Articulo::findOrfail($request->id);
        //tomar los datos de request
        $articulo->idcategoria = $request->idcategoria;
        $articulo->idgramaje = $request->idgramaje;
        $articulo->nombre = $request->nombre;
        $articulo->concentracion = $request->concentracion;
        $articulo->administracion = $request->administracion;
        $articulo->presentacion = $request->presentacion;
        $articulo->items = $request->items;
        $articulo->condicion = '1'; //activo
        //guardar el objeto en la tabla
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $articulo =  Articulo::findOrfail($request->id);

        //cambiar la condicion a 0
        $articulo->condicion = '0'; //desactivo

        //guardar el objeto en la tabla
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $articulo =  Articulo::findOrfail($request->id);

        //cambiar la condicion a 1
        $articulo->condicion = '1'; //activo

        //guardar el objeto en la tabla
        $articulo->save();
    }
/*function para selecionar medicamentos para el select de la vista de nventario para ingresar el producto*/
    public function selectArticulo(Request $request){

        if (!$request->ajax()) return redirect('/'); 

        $articulos = Articulo::where('condicion', '=', '1')

        ->select('id','nombre')->orderBy('nombre','asc')->get();



        return ['articulos' => $articulos];

    }

    public function pdf(Request $request, $id){
        $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->join('inventarios', 'inventarios.idproducto', '=', 'inventarios.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje','articulos.nombre',
            'gramajes.gramaje as nombre_gramaje','categorias.nombre as nombre_categoria',
            'articulos.concentracion','articulos.administracion','articulos.presentacion',
            'articulos.items','articulos.condicion')
            ->where('articulos.id', '=', $id)
            ->orderBy('articulos.id', 'desc')->take(1)->get();

        $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
        ->select('inventarios.cantidad_tableta','inventarios.cantidad_blister')
        ->where('inventarios.id', '=', $id)
        ->orderBy('inventarios.id', 'desc')->get();

        $detalles = DetalleInventario::join('inventarios', 'detalle_inventarios.idinventarios', '=', 'inventarios.id')
        ->select('detalle_inventarios.antiguo_tableta','detalle_inventarios.antiguo_blister')
        ->where('detalle_inventarios.idinventarios', '=', $id)
        ->orderBy('detalle_inventarios.id', 'asc')->get();

        $detalle_ingresos = DetalleIngreso::join('ingresos','detalle_ingresos.idingreso','=','ingresos.id')
        ->join('inventarios','detalle_ingresos.idinventario','=','inventarios.id')
        ->join('personas','ingresos.idproveedor','=','personas.id')
        ->select('ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_compra','ingresos.fecha_vencimiento','ingresos.lote','ingresos.pastillas',
        'personas.nombre as proveedor', 'detalle_ingresos.cantidad','detalle_ingresos.cantidad_blister')
        ->where('detalle_ingresos.idinventario', '=',$id)
        ->orderBy('detalle_ingresos.id', 'asc')->get();

      



      /*  $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->select('ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_compra','ingresos.fecha_vencimiento','ingresos.lote',
        'personas.nombre as proveedor')
        ->where('ingresos.id', '=',$id)
        ->orderBy('ingresos.id', 'asc')->get();*/


        $numarticulo=Articulo::select('id')->where('id',$id)->get();
        $pdf = \PDF::loadView('pdf.articulo_kardexpdf',['articulos'=>$articulos,'inventarios'=>$inventarios,'detalles'=>$detalles,
                                                        'detalle_ingresos'=>$detalle_ingresos]);
        return $pdf->download('articulos-'.$numarticulo[0]->id.'.pdf');
    }
    public function obtenerProducto(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
        ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
        ->select('articulos.id','articulos.idcategoria','articulos.idgramaje','articulos.nombre',
        'gramajes.gramaje as nombre_gramaje','categorias.nombre as nombre_categoria',
        'articulos.concentracion','articulos.administracion','articulos.presentacion',
        'articulos.items','articulos.condicion')
        ->where('articulos.id', '=', $id)
        ->orderBy('articulos.id', 'desc')->take(1)->get();
        return ['articulos' => $articulos];
    }

    public function Ingresos(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_compra','ingresos.fecha_vencimiento','ingresos.lote',
        'personas.nombre','users.usuario')
        ->where('ingresos.id', '=',$id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();
    return ['ingreso' => $ingresos];
    }
    public function obtenerIngresos(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
            $detalles =DetalleIngreso::select('detalle_ingresos.cantidad','detalle_ingresos.cantidad_blister',
            'detalle_ingresos.precio')
            ->where('detalle_ingresos.idingreso', '=',$id)
            ->orderBy('detalle_ingresos.id', 'desc')->get();
        return ['detalles' => $detalles];
    }
    


/*

    public function buscarArticulo(Request $request){

        //if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('nombre', '=', $filtro)->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();
        return ['articulos' => $articulos];  
    }


    public function listarArticulo(Request $request){
         if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion','articulos.presentacion','articulos.items','articulos.condicion'
            )->orderBy('articulos.id','desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion', 'articulos.presentacion','articulos.items','articulos.condicion'
            )->where('articulos.'.$criterio,'like','%'.$buscar.'%')->orderBy('articulos.id','desc')->paginate(10);
        }


        /*  if($buscar==''){
            $articulos = Articulo::join('gramajes','articulos.idgramaje', '=', 'gramaje.id')->select(
                'articulos.id','articulos.idgramaje',
            )->orderBy('articulos.id','desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('gramajes','articulos.idgramaje', '=', 'gramaje.id')->select(
                'articulos.id','articulos.idgramaje',
            )->where('articulos.'.$criterio,'like','%'.$buscar.'%')->orderBy('articulos.id','desc')->paginate(10);
        } 
        //listar todos los registros
         return['articulos' => $articulos]; 
    }

   

    public function buscarArticuloVenta(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo', '=', $filtro)
            ->select('id', 'nombre', 'stock', 'precio_venta')
            ->where('stock', '>', '0')
            ->orderBy('nombre', 'asc')
            ->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
                ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.codigo',
                    'articulos.nombre',
                    'categorias.nombre as nombre_categoria',
                    'articulos.precio_venta',
                    'articulos.stock',
                    'articulos.descripcion',
                    'articulos.condicion'
                )->where('articulos.stock', '>', '0')
                ->orderBy('articulos.id', 'desc')->paginate(10);
        } else {
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
                ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.codigo',
                    'articulos.nombre',
                    'categorias.nombre as nombre_categoria',
                    'articulos.precio_venta',
                    'articulos.stock',
                    'articulos.descripcion',
                    'articulos.condicion'
                )->where('articulos.' . $criterio, 'like', '%' . $buscar . '%')
                ->where('articulos.stock', '>', '0')
                ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        //listar todos los registros
        return ['articulos' => $articulos];
    }*/
}

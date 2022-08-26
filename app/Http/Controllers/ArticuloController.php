<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Articulo;
use App\Inventario;
use App\DetalleInventario;
use App\Ingreso;
use App\Kardex;
use App\DetalleIngreso;

class ArticuloController extends Controller
{

    /*public function indexprueva(Request $request)
    {
      //  if (!$request->ajax()) return redirect('/')
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
    }*/

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
                    'articulos.id','articulos.idcategoria','articulos.idgramaje','articulos.nombre',
                    'gramajes.gramaje as nombre_gramaje',
                    'categorias.nombre as nombre_categoria',
                    'articulos.concentracion','articulos.administracion','articulos.presentacion','articulos.items',
                    'articulos.condicion'
                )->where('articulos.' . $criterio, 'like', '%' . $buscar . '%')->orderBy('articulos.id', 'desc')->paginate(8);
        }
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

/*funcion para descargar todos los productos en reporte*/
    public function articulosTodos()
    {
        $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje','articulos.nombre',
                'categorias.nombre as nombre_categoria','gramajes.gramaje as gramaje',
                'articulos.concentracion','articulos.presentacion','articulos.administracion'
                ,'articulos.items'
            )->orderBy('articulos.id', 'desc')->get();
        $cont = Articulo::count();
        $pdf = \PDF::loadView('pdf.articulospdf', ['articulos' => $articulos, 'cont' => $cont]);
        return $pdf->download('Todos_Medicamentos.pdf');
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

   /*function para selecionar medicamentos para el select de la vista de iventario al ingresar el producto*/
    public function selectArticulo(Request $request){

        if (!$request->ajax()) return redirect('/'); 
        $articulos = Articulo::where('condicion', '=', '1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['articulos' => $articulos];

    }

    
  /*funcion del pdf del kardex*/
    public function pdf(Request $request, $id) {
        //if (!$request->ajax()) return redirect('/'); 
        $buscar = $request->desde;
        $criterio = $request->hasta;
          //datos del medicamento
        $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->join('inventarios', 'inventarios.idproducto', '=', 'inventarios.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje','articulos.nombre',
            'gramajes.gramaje as nombre_gramaje','categorias.nombre as nombre_categoria',
            'articulos.concentracion','articulos.administracion','articulos.presentacion',
            'articulos.items','articulos.condicion')
            ->where('articulos.id', '=', $id)
            ->orderBy('articulos.id', 'desc')->take(1)->get();

  //stock del medicamento

        $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
        ->select('inventarios.cantidad_tableta','inventarios.cantidad_blister')
        ->where('inventarios.id', '=', $id)
        ->orderBy('inventarios.id', 'desc')->get();

        $detalles = DetalleInventario::join('inventarios', 'detalle_inventarios.idinventarios', '=', 'inventarios.id')
        ->select('detalle_inventarios.antiguo_tableta','detalle_inventarios.antiguo_blister')
        ->where('detalle_inventarios.idinventarios', '=', $id)
        ->orderBy('detalle_inventarios.id', 'asc')->get();
          //datos de los ingresos del medicamento

      $detalle_ingresos= Kardex::join('detalle_ingresos','kardex.iddetalleingreso','=','detalle_ingresos.id')
      ->join('detalle_inventarios','kardex.iddetalleinventario','=','detalle_inventarios.id')
      ->join('ingresos','detalle_ingresos.idingreso','=','ingresos.id')
      ->join('inventarios','detalle_ingresos.idinventario','=','inventarios.id')
        ->join('proveedores','ingresos.idproveedor','=','proveedores.id')
        ->select('kardex.acciones','ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_compra','proveedores.nombre as proveedor', 'detalle_ingresos.cantidad','detalle_ingresos.cantidad_blister',
        'detalle_ingresos.fecha_vencimiento','detalle_ingresos.lote',
        'detalle_inventarios.antiguo_tableta','detalle_inventarios.antiguo_blister')
       ->whereBetween('ingresos.fecha_compra', [$buscar,$criterio])
         // ->whereBetween('ingresos.fecha_compra', [request()->$buscar,request()->$criterio], '=',$id)
        ->orwhere('detalle_inventarios.idinventarios', '=',$id)
         ->where('detalle_ingresos.idinventario','=',$id)
        // $users = DB::table('users')
        // ->whereBetween('votes', array(1, 100))->get();
         
         ->orderBy('detalle_ingresos.id', 'asc')->get();
  //datos de venta del medicamento
         $detalle_ventas= DB::table('kardexventas')
         ->join('detalle_ventas','kardexventas.iddetalleventa','=','detalle_ventas.id')
         ->join('detalle_inventarios','kardexventas.iddetalleinventariov','=','detalle_inventarios.id')
         ->join('ventas','detalle_ventas.idventa','=','ventas.id')
         ->join('inventarios','detalle_ventas.idinventario','=','inventarios.id')
         //->join('detalle_ingresos','detalle_ingresos.idinventario','=','detalle_ingresos.id')
        // ->join('ingresos','ingresos.id','=','ingresos.id')
         ->join('personas','ventas.idcliente','=','personas.id')
           ->select('ventas.tipo_comprobante','ventas.num_comprobante','ventas.fecha_salida','ventas.descripcion',
           'personas.nombre as cliente', 'detalle_ventas.cantidad','detalle_ventas.cantidad_blister','detalle_ventas.fecha_vencimiento',
           'detalle_ventas.lote',
           'detalle_inventarios.antiguo_tableta','detalle_inventarios.antiguo_blister')
           ->whereBetween('ventas.fecha_salida', [$buscar,$criterio])
           ->orwhere('detalle_inventarios.idinventarios', '=',$id)
           ->where('detalle_ventas.idinventario','=',$id)
            //->where('detalle_ingresos.idingreso','=',$id)
            ->orderBy('detalle_ventas.id', 'asc')->get();
     // $users = DB::table('users')->get();
 
      //return view('user.index', ['users' => $users]);

       /* $detalle_ingresos = DetalleIngreso::join('ingresos','detalle_ingresos.idingreso','=','ingresos.id')
        ->join('inventarios','detalle_ingresos.idinventario','=','inventarios.id')
        ->join('proveedores','ingresos.idproveedor','=','proveedores.id')
        
        ->select('ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_compra','ingresos.fecha_vencimiento','ingresos.lote',
        'proveedores.nombre as proveedor', 'detalle_ingresos.cantidad','detalle_ingresos.cantidad_blister')
      
        //->where('detalle_inventarios.idinventarios', '=',$id)
        ->where('detalle_ingresos.idinventario','=',$id)
        
        
      
        ->orderBy('detalle_ingresos.id', 'asc')->get();*/

      



      /*  $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->select('ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_compra','ingresos.fecha_vencimiento','ingresos.lote',
        'personas.nombre as proveedor')
        ->where('ingresos.id', '=',$id)
        ->orderBy('ingresos.id', 'asc')->get();*/


        $numarticulo=Articulo::select('id')->where('id',$id)->get();
        $pdf = \PDF::loadView('pdf.articulo_kardexpdf',['articulos'=>$articulos,'inventarios'=>$inventarios,'detalles'=>$detalles,
                                                        'detalle_ingresos'=>$detalle_ingresos,'detalle_ventas'=>$detalle_ventas]);
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
            )->orderBy('articulos.id','desc')->paginate(7);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select('articulos.id','articulos.idcategoria','articulos.idgramaje', 'articulos.nombre', 
            'categorias.nombre as nombre_categoria','gramajes.gramaje as nombre_gramaje',  'articulos.concentracion',
            'articulos.administracion', 'articulos.presentacion','articulos.items','articulos.condicion'
            )->where('articulos.'.$criterio,'like','%'.$buscar.'%')->orderBy('articulos.id','desc')->paginate(7);
        }
    }

    public function buscarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $articulos = Articulo::where('nombre', '=', $filtro)
            ->select('id', 'nombre')->orderBy('nombre', 'asc')->take(1)->get();
        return ['articulos' => $articulos];
    }

    public function listarArticuloVenta(Request $request)
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
                    'categorias.nombre as nombre_categoria',
                    'gramajes.gramaje as nombre_gramaje',
                    'articulos.concentracion',
                    'articulos.administracion',
                    'articulos.presentacion',
                    'articulos.items',
                    'articulos.condicion'
                )
                ->orderBy('articulos.id', 'desc')->paginate(10);
        } else {
            $articulos = Articulo::join('categorias', 'articulos.idcategoria', '=', 'categorias.id')
            ->join('gramajes', 'articulos.idgramaje', '=', 'gramajes.id')
            ->select(
                    'articulos.id',
                    'articulos.idcategoria',
                    'articulos.idgramaje',
                    'articulos.nombre',
                    'categorias.nombre as nombre_categoria',
                    'gramajes.gramaje as nombre_gramaje',
                    'articulos.concentracion',
                    'articulos.administracion',
                    'articulos.presentacion',
                    'articulos.items',
                    'articulos.condicion'
                )->where('articulos.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        //listar todos los registros
        return ['articulos' => $articulos];
    }
}

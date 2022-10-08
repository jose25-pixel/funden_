<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\DetalleInventario;
use App\Inventario;
use App\kardex;
use App\kardexxv;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Reporte_Art extends Controller
{
    public function reporte_dias(Request $request, $id)
    {

        $buscar = $request->desde;
        $criterio = $request->hasta;

        $articulos = Articulo::whereDate('nombre', Carbon::today())->get();
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
                'articulos.condicion'
            )
            ->where('articulos.id', '=', $id)
            ->orderBy('articulos.id', 'desc')->take(1)->get();

        $inventarios = Inventario::whereDate('idproducto', Carbon::today())->get();
        $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
            ->select('inventarios.cantidad_tableta', 'inventarios.cantidad_blister')
            ->where('inventarios.id', '=', $id)
            ->orderBy('inventarios.id', 'desc')->get();

        $detalles = DetalleInventario::whereDate('idinventarios', Carbon::today())->get();
        $detalles = DetalleInventario::join('inventarios', 'detalle_inventarios.idinventarios', '=', 'inventarios.id')
            ->select('detalle_inventarios.antiguo_tableta', 'detalle_inventarios.antiguo_blister')
            ->where('detalle_inventarios.idinventarios', '=', $id)
            ->orderBy('detalle_inventarios.id', 'asc')->get();

        $detalle_ingresos = kardex::whereDate('iddetalleingreso', Carbon::today())->get();
        $detalle_ingresos = Kardex::join('detalle_ingresos', 'kardex.iddetalleingreso', '=', 'detalle_ingresos.id')
            ->join('detalle_inventarios', 'kardex.iddetalleinventario', '=', 'detalle_inventarios.id')
            ->join('ingresos', 'detalle_ingresos.idingreso', '=', 'ingresos.id')
            ->join('inventarios', 'detalle_ingresos.idinventario', '=', 'inventarios.id')
            ->join('proveedores', 'ingresos.idproveedor', '=', 'proveedores.id')
            ->select(
                'kardex.acciones',
                'ingresos.tipo_comprobante',
                'ingresos.serie_comprobante',
                'ingresos.num_comprobante',
                'ingresos.fecha_compra',
                'proveedores.nombre as proveedor',
                'detalle_ingresos.cantidad',
                'detalle_ingresos.cantidad_blister',
                'detalle_ingresos.fecha_vencimiento',
                'detalle_ingresos.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ingresos.fecha_compra', [$buscar, $criterio])
            ->orwhere('detalle_inventarios.idinventarios', '=', $id)
            ->where('detalle_ingresos.idinventario', '=', $id)

            ->orderBy('detalle_ingresos.id', 'asc')->get();


        $detalle_ventas = DB::table('kardexventas')
            ->join('detalle_ventas', 'kardexventas.iddetalleventa', '=', 'detalle_ventas.id')
            ->join('detalle_inventarios', 'kardexventas.iddetalleinventariov', '=', 'detalle_inventarios.id')
            ->join('ventas', 'detalle_ventas.idventa', '=', 'ventas.id')
            ->join('inventarios', 'detalle_ventas.idinventario', '=', 'inventarios.id')
            ->join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->select(
                'ventas.tipo_comprobante',
                'ventas.num_comprobante',
                'ventas.fecha_salida',
                'ventas.descripcion',
                'personas.nombre as cliente',
                'detalle_ventas.cantidad',
                'detalle_ventas.cantidad_blister',
                'detalle_ventas.fecha_vencimiento',
                'detalle_ventas.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ventas.fecha_salida', [$buscar, $criterio])
            ->orwhere('detalle_inventarios.idinventarios', '=', $id)
            ->where('detalle_ventas.idinventario', '=', $id)
            ->orderBy('detalle_ventas.id', 'asc')->get();


        $numarticulo = Articulo::whereDate('nombre', Carbon::today())->get();
        $numarticulo = Articulo::select('id')->where('id', $id)->get();

        $total = $articulos->sum('total');
        $total = $inventarios->sum('total');
        $total = $detalles->sum('total');
        $total = $detalle_ingresos->sum('total');
        $total = $detalle_ventas->sum('total');
        $total = $numarticulo->sum('total');




        return view('report.reportedia', compact('articulos', 'inventarios', 'detalles', 'detalle_ingresos', 'detalle_ventas', 'numarticulo', 'total'));
    }

    public function reporte_fechas(Request $request, $id)
    {
        $buscar = $request->desde;
        $criterio = $request->hasta;

        $articulos = Articulo::whereDate('nombre', Carbon::today())->get();
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
                'articulos.condicion'
            )
            ->where('articulos.id', '=', $id)
            ->orderBy('articulos.id', 'desc')->take(1)->get();

        $inventarios = Inventario::whereDate('idproducto', Carbon::today())->get();
        $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
            ->select('inventarios.cantidad_tableta', 'inventarios.cantidad_blister')
            ->where('inventarios.id', '=', $id)
            ->orderBy('inventarios.id', 'desc')->get();

        $detalles = DetalleInventario::whereDate('idinventarios', Carbon::today())->get();
        $detalles = DetalleInventario::join('inventarios', 'detalle_inventarios.idinventarios', '=', 'inventarios.id')
            ->select('detalle_inventarios.antiguo_tableta', 'detalle_inventarios.antiguo_blister')
            ->where('detalle_inventarios.idinventarios', '=', $id)
            ->orderBy('detalle_inventarios.id', 'asc')->get();

        $detalle_ingresos = kardex::whereDate('iddetalleingreso', Carbon::today())->get();
        $detalle_ingresos = Kardex::join('detalle_ingresos', 'kardex.iddetalleingreso', '=', 'detalle_ingresos.id')
            ->join('detalle_inventarios', 'kardex.iddetalleinventario', '=', 'detalle_inventarios.id')
            ->join('ingresos', 'detalle_ingresos.idingreso', '=', 'ingresos.id')
            ->join('inventarios', 'detalle_ingresos.idinventario', '=', 'inventarios.id')
            ->join('proveedores', 'ingresos.idproveedor', '=', 'proveedores.id')
            ->select(
                'kardex.acciones',
                'ingresos.tipo_comprobante',
                'ingresos.serie_comprobante',
                'ingresos.num_comprobante',
                'ingresos.fecha_compra',
                'proveedores.nombre as proveedor',
                'detalle_ingresos.cantidad',
                'detalle_ingresos.cantidad_blister',
                'detalle_ingresos.fecha_vencimiento',
                'detalle_ingresos.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ingresos.fecha_compra', [$buscar, $criterio])
            ->orwhere('detalle_inventarios.idinventarios', '=')
            ->where('detalle_ingresos.idinventario', '=', $id)

            ->orderBy('detalle_ingresos.id', 'asc')->get();


        $detalle_ventas = DB::table('kardexventas')
            ->join('detalle_ventas', 'kardexventas.iddetalleventa', '=', 'detalle_ventas.id')
            ->join('detalle_inventarios', 'kardexventas.iddetalleinventariov', '=', 'detalle_inventarios.id')
            ->join('ventas', 'detalle_ventas.idventa', '=', 'ventas.id')
            ->join('inventarios', 'detalle_ventas.idinventario', '=', 'inventarios.id')
            ->join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->select(
                'ventas.tipo_comprobante',
                'ventas.num_comprobante',
                'ventas.fecha_salida',
                'ventas.descripcion',
                'personas.nombre as cliente',
                'detalle_ventas.cantidad',
                'detalle_ventas.cantidad_blister',
                'detalle_ventas.fecha_vencimiento',
                'detalle_ventas.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ventas.fecha_salida', [$buscar, $criterio])
            ->orwhere('detalle_inventarios.idinventarios', '=')
            ->where('detalle_ventas.idinventario', '=', $id)
            ->orderBy('detalle_ventas.id', 'asc')->get();


        $numarticulo = Articulo::whereDate('nombre', Carbon::today())->get();
        $numarticulo = Articulo::select('id')->where('id')->get();

        $total = $articulos->sum('total');
        $total = $inventarios->sum('total');
        $total = $detalles->sum('total');
        $total = $detalle_ingresos->sum('total');
        $total = $detalle_ventas->sum('total');
        $total = $numarticulo->sum('total');




        return view('report.reportefecha', compact('articulos', 'inventarios', 'detalles', 'detalle_ingresos', 'detalle_ventas', 'numarticulo', 'total'));
    }

    public function reporte_resultados(Request $request, $id, $desde, $hasta)
    {
        $fi = $desde;
        $ff = $hasta;

        $buscar = $request->desde;
        $criterio = $request->hasta;

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
                'articulos.condicion'
            )
            ->where('articulos.id', '=', $id)
            ->orderBy('articulos.id', 'desc')->take(1)->get();
        $inventarios = Inventario::join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
            ->select('inventarios.cantidad_tableta', 'inventarios.cantidad_blister')
            ->where('inventarios.id', '=', $id)
            ->orderBy('inventarios.id', 'desc')->get();


            $detalle_ingresos = Kardex::join('detalle_ingresos', 'kardex.iddetalleingreso', '=', 'detalle_ingresos.id')
            ->join('detalle_inventarios', 'kardex.iddetalleinventario', '=', 'detalle_inventarios.id')
            ->join('ingresos', 'detalle_ingresos.idingreso', '=', 'ingresos.id')
            ->join('inventarios', 'detalle_ingresos.idinventario', '=', 'inventarios.id')
            ->join('proveedores', 'ingresos.idproveedor', '=', 'proveedores.id')
            ->select(
                'kardex.acciones',
                'ingresos.tipo_comprobante',
                'ingresos.serie_comprobante',
                'ingresos.num_comprobante',
                'ingresos.fecha_compra',
                'proveedores.nombre as proveedor',
                'detalle_ingresos.cantidad',
                'detalle_ingresos.cantidad_blister',
                'detalle_ingresos.fecha_vencimiento',
                'detalle_ingresos.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ingresos.fecha_compra', [$fi, $ff])
            ->orwhere('detalle_inventarios.idinventarios', '=')
            ->where('detalle_ingresos.idinventario', '=', $id)

            ->orderBy('detalle_ingresos.id', 'asc')->get();


            $detalle_ventas = kardexxv::join('detalle_ventas', 'kardexventas.iddetalleventa', '=', 'detalle_ventas.id')
            ->join('detalle_inventarios', 'kardexventas.iddetalleinventariov', '=', 'detalle_inventarios.id')
            ->join('ventas', 'detalle_ventas.idventa', '=', 'ventas.id')
            ->join('inventarios', 'detalle_ventas.idinventario', '=', 'inventarios.id')
            ->join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->select(
                'ventas.tipo_comprobante',
                'ventas.num_comprobante',
                'ventas.fecha_salida',
                'ventas.descripcion',
                'personas.nombre as cliente',
                'detalle_ventas.cantidad',
                'detalle_ventas.cantidad_blister',
                'detalle_ventas.fecha_vencimiento',
                'detalle_ventas.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ventas.fecha_salida', [$fi, $ff])
            ->orwhere('detalle_inventarios.idinventarios', '=')
            ->where('detalle_ventas.idinventario', '=', $id)
            ->orderBy('detalle_ventas.id', 'asc')->get();


        /* $detalle_ventas = DB::table('ventas')->whereBetween('fecha_salida', [$fi, $ff])->get(); */
       /*  $detalle_ingresos = DB::table('ingresos')->whereBetween('fecha_compra', [$fi, $ff])->get(); */
        return $articulos . $inventarios . $detalle_ventas . $detalle_ingresos;
        /* dd($detalle_ventas) ; */
        /* return $detalle_ventas; */

        /* dd($detalle_ingresos); */
        /* return $detalle_ventas; */





        

        /*  $detalle_ventas = DB::table('kardexventas')->whereBetween('id_kardexventas', [$fi, $ff])
            ->join('detalle_ventas', 'kardexventas.iddetalleventa', '=', 'detalle_ventas.id')
            ->join('detalle_inventarios', 'kardexventas.iddetalleinventariov', '=', 'detalle_inventarios.id')
            ->join('ventas', 'detalle_ventas.idventa', '=', 'ventas.id')
            ->join('inventarios', 'detalle_ventas.idinventario', '=', 'inventarios.id')
            ->join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->select(
                'ventas.tipo_comprobante',
                'ventas.num_comprobante',
                'ventas.fecha_salida',
                'ventas.descripcion',
                'personas.nombre as cliente',
                'detalle_ventas.cantidad',
                'detalle_ventas.cantidad_blister',
                'detalle_ventas.fecha_vencimiento',
                'detalle_ventas.lote',
                'detalle_inventarios.antiguo_tableta',
                'detalle_inventarios.antiguo_blister'
            )
            ->whereBetween('ventas.fecha_salida', [$buscar, $criterio])
            ->orwhere('detalle_inventarios.idinventarios', '=')
            ->where('detalle_ventas.idinventario', '=', $id)
            ->orderBy('detalle_ventas.id', 'asc')->get(); */


        /* $numarticulo = Articulo::whereBetween('created_at', [$fi, $ff])->get();
        $numarticulo = Articulo::select('id')->where('id')->get(); */

        /* $total = $articulos->sum('total');
        $total = $inventarios->sum('total'); */
        /*  $total = $detalles->sum('total');
        $total = $detalle_ingresos->sum('total'); */
        /* $total = $detalle_ventas->sum('total'); */
        /* $total = $numarticulo->sum('total'); */

        return redirect()->route('reporte_resultados');
    }
}

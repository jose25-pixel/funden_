<?php

namespace App\Http\Controllers;

use App\DetalleVenta;
use App\kardexxv;
use App\DetalleInventario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Venta;
use Carbon\Carbon;
use Exception;


class VentaController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.fecha_salida','ventas.tipo_comprobante','ventas.num_comprobante',
            'ventas.total','ventas.descripcion','ventas.estado','personas.nombre',
            'users.usuario')
            ->orderBy('ventas.id', 'desc')->paginate(15);
        }
        else{
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.fecha_salida','ventas.tipo_comprobante','ventas.num_comprobante',
            'ventas.total','ventas.descripcion','ventas.estado','personas.nombre',
            'users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ventas.id', 'desc')->paginate(15);
        }
        
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }

    public function obtenerCabecera(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $id = $request->id;
            $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.fecha_salida','ventas.tipo_comprobante','ventas.num_comprobante',
            'ventas.total','ventas.descripcion','ventas.estado','personas.nombre',
            'users.usuario')
            ->where('ventas.id', '=', $id)
            ->orderBy('ventas.id', 'desc')->take(1)->get();
        return ['venta' => $venta ];
    }

    public function obtenerDetalles(Request $request){

        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
            $detalles = DetalleVenta::join('inventarios','detalle_ventas.idinventario','=','inventarios.id')
            ->join('articulos','inventarios.idproducto','=','articulos.id')
            ->select('detalle_ventas.cantidad','detalle_ventas.cantidad_blister','detalle_ventas.precio',
            'detalle_ventas.fecha_vencimiento','detalle_ventas.lote',
            'articulos.nombre as articulo')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')->get();
        return ['detalles' => $detalles ];
    }
   
    
    public function pdf(Request $request, $id){
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id',
        'ventas.fecha_salida','ventas.tipo_comprobante','ventas.num_comprobante',
        'ventas.total','ventas.descripcion','ventas.estado',
        'personas.nombre','personas.tipo_documento','personas.num_documento','personas.direccion','personas.email','personas.telefono',
        'users.usuario')
        ->where('ventas.id', '=', $id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('inventarios','detalle_ventas.idinventario','=','inventarios.id')
        ->join('articulos','inventarios.idproducto','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.cantidad_blister','detalle_ventas.precio','detalle_ventas.fecha_vencimiento','detalle_ventas.lote',
        'articulos.nombre as articulo')
        ->where('detalle_ventas.idventa', '=', $id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa=Venta::select('fecha_salida')->where('id',$id)->get();        
        $pdf = \PDF::loadView('pdf.venta',['venta'=>$venta, 'detalles'=>$detalles]);
        return  $pdf
        ->stream('venta-'.$numventa[0]->fecha_salida.'.pdf');
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            //$mytime = Carbon::now('America/El_Salvador');
            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->num_comprobante = $request->num_comprobante;
            $venta->fecha_salida = $request->fecha_salida;
            $venta->total = $request->total;
            $venta->descripcion = $request->descripcion;
            $venta->estado = 'Registrado';
            $venta->save();
            $detalles = $request->data;//Array de detalles
            //recorrer todos los elementos
            foreach ($detalles as $ep => $det)
             {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idinventario= $det['idinventario'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->cantidad_blister = $det['cantidad_blister'];
                $detalle->precio = $det['precio'];
                $detalle->fecha_vencimiento = $det['fecha_vencimiento'];
                $detalle->lote = $det['lote'];
                $detalle->save();
            
           $data = DetalleInventario::latest('id')->first();
                
            $kardex = new Kardexxv();
            $kardex->iddetalleventa = $detalle->id;
            $kardex->iddetalleinventariov = $data->id; //$request->id detalle_inventario;
            $kardex->acciones = 'Venta';
            $kardex->save();
        }
            DB::commit();
            return[ 
                'id' => $venta->id
            ];

        } catch (Exception $e){
            DB::rollBack();
        }
   
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulada';
        $venta->save();
    }
}

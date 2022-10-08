<?php

namespace App\Http\Controllers;
use App\DetalleIngreso;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DetalleInventario;
use App\Ingreso;
use App\Kardex;
use Carbon\Carbon;
use Exception;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $ingresos = Ingreso::join('proveedores','ingresos.idproveedor','=','proveedores.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_compra',
            'ingresos.total','ingresos.estado',
            'proveedores.nombre',
            'users.usuario')
            ->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        else{
            $ingresos = Ingreso::join('proveedores','ingresos.idproveedor','=','proveedores.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_compra',
            'ingresos.total','ingresos.estado','proveedores.nombre',
            'users.usuario')           
            ->where('ingresos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }

    public function obtenerCabecera(Request $request){

        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
            $ingreso = Ingreso::join('proveedores','ingresos.idproveedor','=','proveedores.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_compra',
            'ingresos.total','proveedores.nombre','users.usuario')
            ->where('ingresos.id', '=', $id)
            ->orderBy('ingresos.id', 'desc')->take(1)->get();
        return ['ingreso' => $ingreso ];
    }

    public function obtenerDetalles(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $id = $request->id;
            $detalles = DetalleIngreso::join('inventarios','detalle_ingresos.idinventario','=','inventarios.id')
            ->join('articulos','inventarios.idproducto','=','articulos.id')
            ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','detalle_ingresos.cantidad_blister',
            'articulos.nombre as articulo','detalle_ingresos.fecha_vencimiento','detalle_ingresos.lote')
            ->where('detalle_ingresos.idingreso', '=', $id)
            ->orderBy('detalle_ingresos.id', 'desc')->get();
        return ['detalles' => $detalles ];
    }


    public function EditarCabecera(Request $request){

        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
            $ingreso = Ingreso::join('proveedores','ingresos.idproveedor','=','proveedores.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_compra',
            'ingresos.total','proveedores.nombre','users.usuario')
            ->where('ingresos.id', '=', $id)
            ->orderBy('ingresos.id', 'desc')->take(1)->get();
        return ['ingreso' => $ingreso ];
    }

    public function EditarDetalles(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $id = $request->id;
            $detalles = DetalleIngreso::join('inventarios','detalle_ingresos.idinventario','=','inventarios.id')
            ->join('articulos','inventarios.idproducto','=','articulos.id')
            ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','detalle_ingresos.cantidad_blister',
            'articulos.nombre as articulo','detalle_ingresos.fecha_vencimiento','detalle_ingresos.lote')
            ->where('detalle_ingresos.idingreso', '=', $id)
            ->orderBy('detalle_ingresos.id', 'desc')->get();
        return ['detalles' => $detalles ];
    }


    public function pdfIngreso(Request $request, $id)
    {
        $ingreso = Ingreso::join('proveedores','ingresos.idproveedor','=','proveedores.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
        'ingresos.num_comprobante','ingresos.fecha_compra',
        'ingresos.total','ingresos.created_at','proveedores.nombre','proveedores.tipo_documento',
        'proveedores.num_documento','proveedores.direccion','proveedores.email',
        'proveedores.telefono','users.usuario')
        ->where('ingresos.id', '=', $id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();

        $detalles = DetalleIngreso::join('inventarios','detalle_ingresos.idinventario','=','inventarios.id')
            ->join('articulos','inventarios.idproducto','=','articulos.id')
            ->select('detalle_ingresos.cantidad','detalle_ingresos.precio',
            'detalle_ingresos.cantidad_blister','detalle_ingresos.fecha_vencimiento',
            'detalle_ingresos.lote',
            'articulos.nombre as articulo')
            ->where('detalle_ingresos.idingreso', '=', $id)
            ->orderBy('detalle_ingresos.id', 'desc')->get();

            $feingreso=Ingreso::select('fecha_compra')->where('id',$id)->get();

            $pdf = \PDF::loadView('pdf.ingreso',['ingreso'=>$ingreso,'detalles'=>$detalles]);
            return $pdf->stream('ingreso-'.$feingreso[0]->fecha_compra.'.pdf');

    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->fecha_compra = $request->fecha_compra;
            $ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            $ingreso->save();

            $detalles = $request->data;//Array de detalles

            //recorrer todos los elementos
            foreach ($detalles as $ep => $det) {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idinventario = $det['idinventario'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->cantidad_blister = $det['cantidad_blister'];
                $detalle->precio = $det['precio'];
                $detalle->fecha_vencimiento = $det['fecha_vencimiento'];
                $detalle->lote = $det['lote'];
                $detalle->save();
                
          $data = DetalleInventario::latest('id')->first();
                
        $kardes = new Kardex();
        $kardes->iddetalleingreso = $detalle->id;
        $kardes->iddetalleinventario = $data->id; //$request->id detalle_inventario;
        $kardes->acciones = 'compra';
        $kardes->save();
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $ingreso = Ingreso::find($request->id);        
                $ingreso->idproveedor = $request->idproveedor;
           // $ingreso->idusuario = \Auth::user()->id;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->fecha_compra = $request->fecha_compra;
            $ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            $ingreso->save();

         /*   $detalles = $request->data;//Array de detalles

            //recorrer todos los elementos
            foreach ($detalles as $ep => $det) {
            
                $detalle =DetalleIngreso::findOrfail($request->id);  
                $detalle->idingreso = $ingreso->id;
                $detalle->idinventario = $det['idinventario'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->cantidad_blister = $det['cantidad_blister'];
                $detalle->precio = $det['precio'];
                $detalle->fecha_vencimiento = $det['fecha_vencimiento'];
                $detalle->lote = $det['lote'];
                $detalle->save();
                
      /*    $data = DetalleInventario::latest('id')->first();
                
        $kardes = new Kardex();
        $kardes->iddetalleingreso = $detalle->id;
        $kardes->iddetalleinventario = $data->id; //$request->id detalle_inventario;
        $kardes->acciones = 'compra';
        $kardes->save();
            }*/
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();

      /*  $data = DetalleInventario::latest('id');
        $datadetallle = DetalleIngreso::latest('id');
      
        $nueva=$data["antiguo_tableta"];
        $nuevaa=$data["antiguo_blister"];
        $nuevad=$datadetallle["cantidad"];
        $nuevaad=$data["cantidad_blister"];

        $kardes = new DetalleInventario();*/
        
    }


    public function destroy(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');
        Ingreso::findOrFail($request->id)->delete();
    }
}

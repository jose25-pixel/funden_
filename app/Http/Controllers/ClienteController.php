<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Persona;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\kardexxv;
use App\Kardex;
use App\DetalleIngreso;
use App\DetalleVenta;
use App\Venta;

class ClienteController extends Controller
{
    
    public function index( Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $personas = Persona::orderBy('id','desc')
            ->paginate(12);
        }
        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id','desc')
            ->paginate(12);
        }
        return[
            'pagination' =>[
                'total' => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page' => $personas->perPage(),
                'last_page' => $personas->lastPage(),
                'from' => $personas->firstItem(),
                'to' => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }


    public function reporteclientes(Request $request, $id, $desde, $hasta)  {
        $dede = $request->desde;
        $hata = $request->hasta;
       // if (!$request->ajax()) return redirect('/');
       $detalle_clientes = kardexxv::join('detalle_ventas', 'kardexventas.iddetalleventa', '=', 'detalle_ventas.id')
       ->join('ventas', 'detalle_ventas.idventa', '=', 'ventas.id')
       ->join('inventarios','detalle_ventas.idinventario','=','inventarios.id')
       ->join('articulos', 'inventarios.idproducto', '=', 'articulos.id')
       ->join('personas', 'ventas.idcliente', '=', 'personas.id')
       ->select('ventas.tipo_comprobante','ventas.num_comprobante','ventas.fecha_salida','ventas.descripcion',
       'personas.nombre as cliente','detalle_ventas.lote','detalle_ventas.fecha_vencimiento',
       'detalle_ventas.cantidad','detalle_ventas.cantidad_blister',"articulos.nombre")
       ->where('ventas.idcliente', '=', $id)->whereBetween('ventas.fecha_salida', [$dede, $hata])->get();

     $numarticulo=Persona::select('nombre')->where('id',$id)->get();
     $pdf = \PDF::loadView('pdf.cliente_fecha',['detalle_clientes'=>$detalle_clientes]);
     return $pdf
     //->setPaper('carta', 'landscape')
     ->stream('reporte-ciente-'.$numarticulo[0]->nombre.'.pdf');
    }

    public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $clientes = Persona::where('nombre', 'like', '%'. $filtro . '%')
        ->orWhere('num_documento', 'like', '%'. $filtro . '%')
        ->select('id','nombre','num_documento')
        ->orderBy('nombre', 'asc')->get();

        return ['clientes' => $clientes];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $persona = new Persona();
        //tomar los datos de request
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        //guardar el objeto en la tabla
        $persona->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $persona =  Persona::findOrfail($request->id);

         //tomar los datos de request
         $persona->nombre = $request->nombre;
         $persona->tipo_documento = $request->tipo_documento;
         $persona->num_documento = $request->num_documento;
         $persona->direccion = $request->direccion;
         $persona->telefono = $request->telefono;
         $persona->email = $request->email;
 
         //guardar el objeto en la tabla
         $persona->save();
    }
}

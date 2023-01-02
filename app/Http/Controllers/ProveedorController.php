<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Proveedor;

class ProveedorController extends Controller
{
    //Función para moostrar los proveedores.
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $proveedores = Proveedor::select('proveedores.id','proveedores.nombre','proveedores.tipo_documento',
            'proveedores.num_documento','proveedores.direccion','proveedores.telefono',
            'proveedores.email','proveedores.contacto','proveedores.telefono_contacto','condicion')
            ->orderBy('proveedores.id', 'desc')->paginate(12);
        }
        else{
            $proveedores = Proveedor::select('proveedores.id','proveedores.nombre','proveedores.tipo_documento',
            'proveedores.num_documento','proveedores.direccion','proveedores.telefono',
            'proveedores.email','proveedores.contacto','proveedores.telefono_contacto','condicion')            
            ->where('proveedores.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('proveedores.id', 'desc')->paginate(12);
        }
        return [
            'pagination' => [
                'total'        => $proveedores->total(),
                'current_page' => $proveedores->currentPage(),
                'per_page'     => $proveedores->perPage(),
                'last_page'    => $proveedores->lastPage(),
                'from'         => $proveedores->firstItem(),
                'to'           => $proveedores->lastItem(),
            ],
            'proveedores' => $proveedores
        ];
    }

    //Función para listar el prveedor en el ingreso
    public function selectProveedor(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $proveedores = Proveedor::where('proveedores.nombre', 'like', '%'. $filtro . '%')
        ->where('proveedores.condicion', '=','1')
        ->orWhere('proveedores.num_documento', 'like', '%'. $filtro . '%')
        ->select('proveedores.id','proveedores.nombre','proveedores.num_documento')
        ->orderBy('proveedores.nombre', 'asc')->get();
        return ['proveedores' => $proveedores];
    }

    //Función para guardar datos en la base de datos
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
       
            $proveedor = new Proveedor();
            $proveedor->nombre = $request->nombre;
            $proveedor->tipo_documento = $request->tipo_documento;
            $proveedor->num_documento = $request->num_documento;
            $proveedor->direccion = $request->direccion;
            $proveedor->telefono = $request->telefono;
            $proveedor->email = $request->email;
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->condicion = 1; //activo
            $proveedor->save();

            DB::commit();
        } catch(Exception $e){

            DB::rollBack();
          }
    }

    //Función para actualizar el dato de proveedor
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            //Buscar primero el proveedor a modificar
            $proveedor = Proveedor::findOrFail($request->id);
            $proveedor->nombre = $request->nombre;
            $proveedor->tipo_documento = $request->tipo_documento;
            $proveedor->num_documento = $request->num_documento;
            $proveedor->direccion = $request->direccion;
            $proveedor->telefono = $request->telefono;
            $proveedor->email = $request->email;
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->condicion = 1; 
            $proveedor->save();
    }

    //Función para desactivar el proveedor
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proveedor =  Proveedor::findOrfail($request->id);
        //cambiar la condicion a 0
        $proveedor->condicion = 0; //desactivo
        //guardar el objeto en la tabla
        $proveedor->save();
    }

    //Función para actviar el registro de proveedor
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          $proveedor =  Proveedor::findOrfail($request->id);
          //cambiar la condicion a 1
          $proveedor->condicion = 1; //activo
          //guardar el objeto en la tabla
          $proveedor->save();
    }
}

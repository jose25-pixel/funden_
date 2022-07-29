<?php

namespace App\Http\Controllers;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Función para visualizar los usuarios.
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre','users.tipo_documento',
            'users.num_documento','users.direccion','users.telefono',
            'users.email','users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol')
            ->orderBy('users.id', 'desc')->paginate(5);
        }
        else{
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre','users.tipo_documento',
            'users.num_documento','users.direccion','users.telefono',
            'users.email','users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol')            
            ->where('users.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('users.id', 'desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'users' => $users
        ];
    }

    //Función para guardar datos en la base de datos
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            $user= new User();
            $user->nombre = $request->nombre;
            $user->tipo_documento = $request->tipo_documento;
            $user->num_documento = $request->num_documento;
            $user->direccion = $request->direccion;
            $user->telefono = $request->telefono;
            $user->email = $request->email;
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol; 
            $user->save();
    }
   
    //Función para actualizar usuarios en la base de datos
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            //Buscar primero el usuario a modificar
            $user = User::findOrFail($request->id);
            $user->nombre = $request->nombre;
            $user->tipo_documento = $request->tipo_documento;
            $user->num_documento = $request->num_documento;
            $user->direccion = $request->direccion;
            $user->telefono = $request->telefono;
            $user->email = $request->email;
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();
    }

    //Función para desactivar el usuario
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    //Función para activar el usuario
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}

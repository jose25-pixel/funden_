<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\RouteGroup;

Route::group(['middleware' => ['guest']], function(){
   
        Route::get('/', 'Auth\LoginController@showLoginForm');
        Route::post('/login', 'Auth\LoginController@login')->name('login'); 
});

Route::group(['middleware' => ['auth']], function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController');


    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Almacenero']], function(){

        //listar todos los datos de la tabla
        Route::get('/categoria', 'CategoriaController@index');
        
        //insertar registros en la tabla
        Route::post('/categoria/registrar', 'CategoriaController@store');
        
        //insertar registros en la tabla
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        
        //desactivar registros en la tabla
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        
        //activar registros en la tabla
        Route::put('/categoria/activar', 'CategoriaController@activar');
        
        //para el selectCategoria
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

        //para gramaje
        //listar todos los datos de la tabla
        Route::get('/gramaje', 'GramajeController@index');
        
        //insertar registros en la tabla
        Route::post('/gramaje/registrar', 'GramajeController@store');
        
        //insertar registros en la tabla
        Route::put('/gramaje/actualizar', 'GramajeController@update');
        
        //desactivar registros en la tabla
        Route::put('/gramaje/desactivar', 'GramajeController@desactivar');
        
        //activar registros en la tabla
        Route::put('/gramaje/activar', 'GramajeController@activar');
        
        //para el selectCategoria
        Route::get('/gramaje/selectGramaje', 'GramajeController@selectGramaje');

       
        //rutas para articulos
        //listar todos los datos de la tabla
        Route::get('/articulo', 'ArticuloController@index');
        
        //insertar registros en la tabla
        Route::post('/articulo/registrar', 'ArticuloController@store');
        
        //insertar registros en la tabla
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        
        //desactivar registros en la tabla
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        
        //activar registros en la tabla
        Route::put('/articulo/activar', 'ArticuloController@activar');
       //Ruta para el selec dinamico en la vista inventario
        //Route::get('/articulo/selectArticulo', 'ArticuloController@selectArticulo');
        //Route::get('/articulo/obtenerProducto', 'ArticuloController@obtenerProducto');
       // Route::get('/articulo/Ingresos', 'ArticuloController@Ingresos');
       // Route::get('/articulo/obtenerIngresos', 'ArticuloController@obtenerIngresos');
      //  Route::get('/articulo/pdf/{id}', 'ArticuloController@pdf')->name('articulos_pfd');

         //buscar articulo
        // Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
         //Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
         Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf')->name('articulos_pdf');
         Route::get('/articulo/prueva', 'ArticuloController@indexprueva');

 
        // Route::post('/inventario/registrar', 'InventarioController@store');
            //desactivar registros en la tabla
        //Route::put('/inventario/desactivar', 'InventarioController@desactivar');
        //activar registros en la tabla
        //Route::put('/inventario/activar', 'InventarioController@activar');


        
        //rutas de proveedor
        Route::get('/proveedor', 'ProveedorController@index');
        //insertar registros en la tabla
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        //insertar registros en la tabla
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        //seleccionar proveedor
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
         //Activar el proveedor
         Route::put('/proveedor/activar', 'ProveedorController@activar');
         //Desactivar el proveedor
         Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
 


        //rutas de los ingresos
        Route::get('/ingreso', 'IngresoController@index');

        Route::post('/ingreso/registrar', 'IngresoController@store');
        
        //desactivar registros en la tabla
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');

    });
    
   
    Route::group(['middleware' => ['Vendedor']], function(){
         //rutas de clientes
        //listar todos los datos de la tabla
        Route::get('/cliente', 'ClienteController@index');
        
        //insertar registros en la tabla
        Route::post('/cliente/registrar', 'ClienteController@store');
        
        //insertar registros en la tabla
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        /*Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');*/

        
   
            //rutas de las ventas
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');



    });


    Route::group(['middleware' => ['Administrador']], function(){

         //listar todos los datos de la tabla
         Route::get('/categoria', 'CategoriaController@index');
         //insertar registros en la tabla
         Route::post('/categoria/registrar', 'CategoriaController@store');
         //insertar registros en la tabla
         Route::put('/categoria/actualizar', 'CategoriaController@update');
         //desactivar registros en la tabla
         Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
         //activar registros en la tabla
         Route::put('/categoria/activar', 'CategoriaController@activar');
         //para el selectCategoria
         Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
 
 
         //rutas para articulos
         //listar todos los datos de la tabla
         Route::get('/articulo', 'ArticuloController@index');
         //insertar registros en la tabla
         Route::post('/articulo/registrar', 'ArticuloController@store');
         //insertar registros en la tabla
         Route::put('/articulo/actualizar', 'ArticuloController@update');
         //desactivar registros en la tabla
         Route::put('/articulo/desactivar', 'ArticuloController@desactivar'); 
         //activar registros en la tabla
         Route::put('/articulo/activar', 'ArticuloController@activar');
         Route::get('/articulo/articulosTodos', 'ArticuloController@articulosTodos')->name('articulos_pdf');
         Route::get('/articulo/pdf/{id}', 'ArticuloController@pdf')->name('articulos_pdf');
         //buscar articulo
        // Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
         //Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
         //Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
         //Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
       
        //Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf')->name('articulos_pdf');


         /*+++++++++++++++++++++++++++Rutas del inventario++++++++++++++++++++++++++++++++++++*/
        //Rutas de listar medicamnetos desde el inventario para la compra
        Route::get('/inventario/buscarArticuloin', 'InventarioController@listarArticuloinventario');
        Route::get('/inventario/buscarArticuloInventario', 'InventarioController@buscarArticuloInventario');
        //Rutas del inventario para venta de medicamento
        Route::get('/inventario/buscarArticuloInventariov', 'InventarioController@buscarInventarioVenta');
        Route::get('/inventario/buscarArticuloInventarioventa', 'InventarioController@listarArticuloinventarioV');
        //rutas para mostrar datos e ingresar datos a inventario
        Route::get('/inventario', 'InventarioController@index');
     
 
 
         //rutas de proveedor
         Route::get('/proveedor', 'ProveedorController@index');
         //insertar registros en la tabla
         Route::post('/proveedor/registrar', 'ProveedorController@store');
         //insertar registros en la tabla
         Route::put('/proveedor/actualizar', 'ProveedorController@update');
         //seleccionar proveedor
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        //rutas de clientes
       //listar todos los datos de la tabla
       Route::get('/cliente', 'ClienteController@index');
       //insertar registros en la tabla
       Route::post('/cliente/registrar', 'ClienteController@store');
       //insertar registros en la tabla
       Route::put('/cliente/actualizar', 'ClienteController@update');
       Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

           //rutas de rol
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        //rutas para users
        //listar todos los datos de la tabla
        Route::get('/user', 'UserController@index');
        //insertar registros en la tabla
        Route::post('/user/registrar', 'UserController@store');
        //insertar registros en la tabla
        Route::put('/user/actualizar', 'UserController@update');
        //desactivar registros en la tabla
        Route::put('/user/desactivar', 'UserController@desactivar');
        //activar registros en la tabla
        Route::put('/user/activar', 'UserController@activar');

        //rutas de los ingresos
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        //desactivar el registro en la tabla
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}', 'IngresoController@pdfIngreso')->name('ingreso_pdf');


         //rutas de las ventas
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');
          Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');
   });
    
   
});


//Route::get('/home', 'HomeController@index')->name('home');

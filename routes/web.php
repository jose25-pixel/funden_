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



Route::group(['middleware' => ['guest']], function(){
       
    //++++ rutas para el login ++++//
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login'); 
});

Route::group(['middleware' => ['auth']], function(){
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController');


    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Usuario']], function(){

       //RUTAS PARA LA TABLA DE CATEGORIA.
        Route::get('/categoria', 'CategoriaController@index'); //listar todos los datos de la tabla
        Route::post('/categoria/registrar', 'CategoriaController@store'); //insertar registros en la tabla
        Route::put('/categoria/actualizar', 'CategoriaController@update'); //insertar registros en la tabla
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');//desactivar registros en la tabla
        Route::put('/categoria/activar', 'CategoriaController@activar'); //activar registros en la tabla
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria'); //para el selectCategoria

        //RUTAS DE GRAMAJE
        Route::get('/gramaje', 'GramajeController@index'); //listar todos los datos de la tabla
        Route::post('/gramaje/registrar', 'GramajeController@store'); //insertar registros en la tabla
        Route::put('/gramaje/actualizar', 'GramajeController@update'); //insertar registros en la tabla
        Route::put('/gramaje/desactivar', 'GramajeController@desactivar'); //desactivar registros en la tabla
        Route::put('/gramaje/activar', 'GramajeController@activar'); //activar registros en la tabla
        Route::get('/gramaje/selectGramaje', 'GramajeController@selectGramaje'); //para el selectGramaje
       
        //RUTAS PARA ARTICULOS
        Route::get('/articulo', 'ArticuloController@index'); //listar todos los datos de la tabla
        Route::post('/articulo/registrar', 'ArticuloController@store'); //insertar registros en la tabla
        Route::put('/articulo/actualizar', 'ArticuloController@update'); //insertar registros en la tabla
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar'); //desactivar registros en la tabla
        Route::put('/articulo/activar', 'ArticuloController@activar'); //activar registros en la tabla
        Route::get('/articulo/articulosTodos', 'ArticuloController@articulosTodos')->name('articulos_pdf'); //pdf con todos los articulos
        Route::get('/articulo/pdf/{id}', 'ArticuloController@pdf')->name('articuloskardex_pdf'); //kardex de medicamento
        Route::get('/articulo/reporte_resultados/{id}/{desde}/{hasta}', 'ArticuloController@reporte_resultados')->name('reporte_resultados');

        //RUTAS PARA INVENTARIO
        Route::get('/inventario', 'InventarioController@index'); //Rutas de listar medicamnetos desde el inventario para la compra
        Route::get('/inventario/buscarArticuloin', 'InventarioController@listarArticuloinventario');
        Route::get('/inventario/buscarArticuloInventario', 'InventarioController@buscarArticuloInventario');
        Route::get('/inventario/buscarArticuloInventariov', 'InventarioController@buscarInventarioVenta');//Rutas del inventario para venta de medicamento
        Route::get('/inventario/buscarArticuloInventarioventa', 'InventarioController@listarArticuloinventarioV');
        Route::get('/inventario/inventarioPdf', 'InventarioController@inventarioPdf')->name('inventarios_pdf');

        //rutas de los ingresos
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::post('/ingreso/update', 'IngresoController@update');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}', 'IngresoController@pdfIngreso')->name('ingreso_pdf');

        //rutas de proveedor
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store'); //insertar registros en la tabla
        Route::put('/proveedor/actualizar', 'ProveedorController@update'); //insertar registros en la tabla
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor'); //seleccionar proveedor
        Route::put('/proveedor/activar', 'ProveedorController@activar'); //Activar el proveedor
        Route::put('/proveedor/desactivar', 'ProveedorController@desactivar'); //Desactivar el proveedor
 
       //rutas de las ventas
       Route::get('/venta', 'VentaController@index');
       Route::post('/venta/registrar', 'VentaController@store');
       Route::put('/venta/desactivar', 'VentaController@desactivar');
       Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
       Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
       Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');
       Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');

       //rutas de clientes
       Route::get('/cliente', 'ClienteController@index'); //listar todos los datos de la tabla
       Route::post('/cliente/registrar', 'ClienteController@store'); //insertar registros en la tabla
       Route::put('/cliente/actualizar', 'ClienteController@update'); //insertar registros en la tabla
       Route::get('/cliente/selectCliente', 'ClienteController@selectCliente'); //seleccionar el cliente
       Route::get('/cliente/reporte_clientes/{id}/{desde}/{hasta}', 'ClienteController@reporteclientes')->name('reporte_clientes'); //reporte de cliente por fechas

       //rutas para users
        Route::get('/user', 'UserController@index'); //listar todos los datos de la tabla
        Route::post('/user/registrar', 'UserController@store'); //insertar registros en la tabla
        Route::put('/user/actualizar', 'UserController@update'); //insertar registros en la tabla
        Route::put('/user/desactivar', 'UserController@desactivar'); //desactivar registros en la tabla
        Route::put('/user/activar', 'UserController@activar'); //activar registros en la tabla
    });
    

    Route::group(['middleware' => ['Administrador']], function(){

         
         Route::get('/categoria', 'CategoriaController@index'); //listar todos los datos de la tabla
         Route::post('/categoria/registrar', 'CategoriaController@store'); //insertar registros en la tabla
         Route::put('/categoria/actualizar', 'CategoriaController@update'); //insertar registros en la tabla
         Route::put('/categoria/desactivar', 'CategoriaController@desactivar'); //desactivar registros en la tabla
         Route::put('/categoria/activar', 'CategoriaController@activar'); //activar registros en la tabla
         Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');//para el selectCategoria

 
         //rutas para articulos
         Route::get('/articulo', 'ArticuloController@index'); //listar todos los datos de la tabla
         Route::post('/articulo/registrar', 'ArticuloController@store'); //insertar registros en la tabla
         Route::put('/articulo/actualizar', 'ArticuloController@update'); //insertar registros en la tabla
         Route::put('/articulo/desactivar', 'ArticuloController@desactivar');  //desactivar registros en la tabla
         Route::put('/articulo/activar', 'ArticuloController@activar');
         Route::get('/articulo/articulosTodos', 'ArticuloController@articulosTodos')->name('articulos_pdf');
         Route::get('/articulo/pdf/{id}', 'ArticuloController@pdf')->name('articuloskardex_pdf');
         Route::get('/articulo/reporte_resultados/{id}/{desde}/{hasta}', 'ArticuloController@reporte_resultados')->name('reporte_resultados');
       
         /*+++++++++++++++++++++++++++Rutas del inventario++++++++++++++++++++++++++++++++++++*/
        //Rutas de listar medicamnetos desde el inventario para la compra
        Route::get('/inventario/buscarArticuloin', 'InventarioController@listarArticuloinventario');
        Route::get('/inventario/buscarArticuloInventario', 'InventarioController@buscarArticuloInventario'); //Rutas del inventario para venta de medicamento
        Route::get('/inventario/buscarArticuloInventariov', 'InventarioController@buscarInventarioVenta');
        Route::get('/inventario/buscarArticuloInventarioventa', 'InventarioController@listarArticuloinventarioV'); //rutas para mostrar datos e ingresar datos a inventario
        Route::get('/inventario', 'InventarioController@index');
        Route::get('/inventario/inventarioPdf', 'InventarioController@inventarioPdf')->name('inventarios_pdf');
     
         //rutas de proveedor
         Route::get('/proveedor', 'ProveedorController@index'); //insertar registros en la tabla
         Route::post('/proveedor/registrar', 'ProveedorController@store'); //insertar registros en la tabla
         Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor'); //seleccionar proveedor

        //rutas de clientes
       Route::get('/cliente', 'ClienteController@index'); //listar todos los datos de la tabla
       Route::post('/cliente/registrar', 'ClienteController@store'); //insertar registros en la tabla
       Route::put('/cliente/actualizar', 'ClienteController@update');
       Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
       Route::get('/cliente/reporte_clientes/{id}/{desde}/{hasta}', 'ClienteController@reporteclientes')->name('reporte_clientes');

        //rutas de rol
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        //rutas para users
        Route::get('/user', 'UserController@index'); //listar todos los datos de la tabla
        Route::post('/user/registrar', 'UserController@store'); //insertar registros en la tabla
        Route::put('/user/actualizar', 'UserController@update'); //insertar registros en la tabla
        Route::put('/user/desactivar', 'UserController@desactivar'); //desactivar registros en la tabla
        Route::put('/user/activar', 'UserController@activar'); //activar registros en la tabla

        //rutas de los ingresos
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::post('/ingreso/update', 'IngresoController@update');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar'); //desactivar el registro en la tabla
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}', 'IngresoController@pdfIngreso')->name('ingreso_pdf');
        Route::delete('/ingreso/eliminar', 'IngresoController@destroy');

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

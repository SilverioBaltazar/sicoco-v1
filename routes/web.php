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

Route::get('/', function () {
    return view('sicinar.login.loginInicio');
});
    // *********** ver link 
    //Route::put('post/{id}', function ($id) {     //escribir validacones })->middleware('auth', 'role:admin');
    
    //************** ¿Cómo validamos multiples usuarios con Middleware? ******//
    //Route::group(['middleware' => ['auth', 'role:employee|manager']], function () {   
    //Route::get('/admin/home', 'AdminController@index')->name('home'); }); 

    Route::group(['prefix' => 'control-interno'], function() {
    
    Route::post('menu', 'usersController@actionLogin')->name('login');
    Route::get('status-sesion/expirada', 'usersController@actionExpirada')->name('expirada');
    Route::get('status-sesion/terminada', 'usersController@actionCerrarSesion')->name('terminada');

    //Route::get('/home', 'HomeController@index')->name('home');
    //Route::get('/admin-home', 'HomeController@index')->middleware('AuthAdmin');       

    // BACK OFFICE DEL SISTEMA
    //Route::get('BackOffice/usuarios'                ,'usuariosController@actionNuevoUsuario')->name('nuevoUsuario');
    //Route::post('BackOffice/usuarios/alta'          ,'usuariosController@actionAltaUsuario')->name('altaUsuario');
    //Route::get('BackOffice/usuarios/todos'          ,'usuariosController@actionVerUsuario')->name('verUsuarios');
    //Route::get('BackOffice/usuarios/{id}/editar'    ,'usuariosController@actionEditarUsuario')->name('editarUsuario');
    //Route::put('BackOffice/usuarios/{id}/actualizar','usuariosController@actionActualizarUsuario')->name('actualizarUsuario');
    //Route::get('BackOffice/usuarios/{id}/Borrar'    ,'usuariosController@actionBorrarUsuario')->name('borrarUsuario'); 

    Route::get('users/ver/todos'        ,'usersController@actionVerUser')->name('verUser');
    Route::get('users/nuevo'            ,'usersController@actionNuevoUser')->name('nuevoUser');
    Route::post('users/nuevo/alta'      ,'usersController@actionAltaUser')->name('altaUser');    
    Route::get('users/{id}/editar/user' ,'usersController@actionEditarUser')->name('editarUser');
    Route::put('users/{id}/actualizar'  ,'usersController@actionActualizarUser')->name('actualizarUser');
    Route::get('users/{id}/Borrar'      ,'usersController@actionBorrarUser')->name('borrarUser');    

    //Catalogos
    //Procesos
    Route::get('proceso/nuevo'      ,'catalogosController@actionNuevoProceso')->name('nuevoProceso');
    Route::post('proceso/nuevo/alta','catalogosController@actionAltaNuevoProceso')->name('AltaNuevoProceso');
    Route::get('proceso/ver/todos'  ,'catalogosController@actionVerProceso')->name('verProceso');
    Route::get('proceso/{id}/editar/proceso','catalogosController@actionEditarProceso')->name('editarProceso');
    Route::put('proceso/{id}/actualizar'    ,'catalogosController@actionActualizarProceso')->name('actualizarProceso');
    Route::get('proceso/{id}/Borrar','catalogosController@actionBorrarProceso')->name('borrarProceso');    
    Route::get('proceso/excel'      ,'catalogosController@exportCatProcesosExcel')->name('downloadprocesos');
    Route::get('proceso/pdf'        ,'catalogosController@exportCatProcesosPdf')->name('catprocesosPDF');
    //Funciones de procesos
    Route::get('funcion/nuevo'      ,'catalogosfuncionesController@actionNuevaFuncion')->name('nuevaFuncion');
    Route::post('funcion/nuevo/alta','catalogosfuncionesController@actionAltaNuevaFuncion')->name('AltaNuevaFuncion');
    Route::get('funcion/ver/todos'  ,'catalogosfuncionesController@actionVerFuncion')->name('verFuncion');
    Route::get('funcion/{id}/editar/funcion','catalogosfuncionesController@actionEditarFuncion')->name('editarFuncion');
    Route::put('funcion/{id}/actualizar'    ,'catalogosfuncionesController@actionActualizarFuncion')->name('actualizarFuncion');
    Route::get('funcion/{id}/Borrar','catalogosfuncionesController@actionBorrarFuncion')->name('borrarFuncion');    
    Route::get('funcion/excel'      ,'catalogosfuncionesController@exportCatFuncionesExcel')->name('downloadfunciones');
    Route::get('funcion/pdf'        ,'catalogosfuncionesController@exportCatFuncionesPdf')->name('catfuncionesPDF');    
    //Actividades
    Route::get('actividad/nuevo'      ,'catalogostrxController@actionNuevaTrx')->name('nuevaTrx');
    Route::post('actividad/nuevo/alta','catalogostrxController@actionAltaNuevaTrx')->name('AltaNuevaTrx');
    Route::get('actividad/ver/todos'  ,'catalogostrxController@actionVerTrx')->name('verTrx');
    Route::get('actividad/{id}/editar/actividad','catalogostrxController@actionEditarTrx')->name('editarTrx');
    Route::put('actividad/{id}/actualizar'      ,'catalogostrxController@actionActualizarTrx')->name('actualizarTrx');
    Route::get('actividad/{id}/Borrar','catalogostrxController@actionBorrarTrx')->name('borrarTrx');    
    Route::get('actividad/excel'      ,'catalogostrxController@exportCatTrxExcel')->name('downloadtrx');
    Route::get('actividad/pdf'        ,'catalogostrxController@exportCatTrxPdf')->name('cattrxPDF');
   
    //Padron de Vehiculos
    //Placas
    Route::get('placas/nueva'           ,'placasController@actionNuevaPlaca')->name('nuevaPlaca');
    Route::post('placas/nueva/alta'     ,'placasController@actionAltaNuevaPlaca')->name('AltaNuevaPlaca');
    Route::get('placas/ver/todas'       ,'placasController@actionVerPlacas')->name('verPlacas');
    Route::get('placas/buscar/todas'    ,'placasController@actionBuscarPlaca')->name('buscarPlaca');    
    Route::get('placas/{id}/editar/placa','placasController@actionEditarPlaca')->name('editarPlaca');
    Route::put('placas/{id}/actualizar' ,'placasController@actionActualizarPlaca')->name('actualizarPlaca');
    Route::get('placas/{id}/Borrar'     ,'placasController@actionBorrarPlaca')->name('borrarPlaca');
    Route::get('placas/excel'           ,'placasController@exportPlacasExcel')->name('placasExcel');
    Route::get('placas/pdf'             ,'placasController@exportPlacasPdf')->name('placasPdf');
    
    Route::get('placas/{id}/editar/placa1','placas1Controller@actionEditarPlaca1')->name('editarPlaca1');
    Route::put('placas/{id}/actualizar1'  ,'placas1Controller@actionActualizarPlaca1')->name('actualizarPlaca1'); 

    //Comprobaciones
    //Recibo de bitacora para descarga de combustible
    Route::get('recibo/nuevo'             ,'reciboController@actionNuevoRecibo')->name('nuevoRecibo');
    Route::post('recibo/nuevo/alta'       ,'reciboController@actionAltaNuevoRecibo')->name('AltaNuevoRecibo');
    Route::get('recibo/ver/todos'         ,'reciboController@actionVerRecibos')->name('verRecibos');
    Route::get('recibo/buscar/todos'      ,'reciboController@actionBuscarRecibo')->name('buscarRecibo');    
    Route::get('recibo/{id}/editar/recibo','reciboController@actionEditarRecibo')->name('editarRecibo');
    Route::put('recibo/{id}/actualizar'   ,'reciboController@actionActualizarRecibo')->name('actualizarRecibo');
    Route::get('recibo/{id}/Borrar'       ,'reciboController@actionBorrarRecibo')->name('borrarRecibo');
    Route::get('recibo/excel'             ,'reciboController@exportReciboExcel')->name('reciboExcel');
    Route::get('recibo/pdf'               ,'reciboController@exportReciboPdf')->name('reciboPdf');
    
    Route::get('recibo/{id}/editar/recibo11','recibo11Controller@actionEditarRecibo11')->name('editarRecibo11');
    Route::put('recibo/{id}/actualizar11'   ,'recibo11Controller@actionActualizarRecibo11')->name('actualizarRecibo11');
    Route::get('recibo/{id}/editar/recibo21','recibo21Controller@actionEditarRecibo21')->name('editarRecibo21');
    Route::put('recibo/{id}/actualizar21'   ,'recibo21Controller@actionActualizarRecibo21')->name('actualizarRecibo21');

    //Numeralia
    Route::get('numeralia/ver/graficaxmarca'    ,'placasController@GplacasxMarca')->name('gplacasxmarca');
    Route::get('numeralia/ver/graficaxtgasto'   ,'placasController@GplacasxTipog')->name('gplacasxtipog');
    Route::get('numeralia/ver/graficaxtoper'    ,'placasController@GplacasxTipoo')->name('gplacasxtipoo');    
    Route::get('numeralia/ver/graficaxtoper2'   ,'placasController@GplacasxTipoo2')->name('gplacasxtipoo2'); 
    Route::get('numeralia/ver/graficadeBitacora','placasController@Gbitacora')->name('gbitacora'); 
    //Route::get('numeralia/ver/mapas'         ,'iapsController@Mapas')->name('verMapas');        
    //Route::get('numeralia/ver/mapas2'        ,'iapsController@Mapas2')->name('verMapas2');        
    //Route::get('numeralia/ver/mapas3'        ,'iapsController@Mapas3')->name('verMapas3');    

});


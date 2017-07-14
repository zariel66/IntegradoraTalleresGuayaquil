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
/*HOME*/
Route::get('/',"HomeController@index");
Route::get("registrartaller","HomeController@registrarTaller");
Route::get("registrotallersubmit","HomeController@registrarTallerSubmit");
Route::get("registrocliente","HomeController@registrarCliente");
Route::get("registroclientesubmit","HomeController@registrarClienteSubmit");
Route::get("serverinfo","HomeController@serverInfo");

/*SESION*/
Route::get('login',"HomeController@login");
Route::get('logout',"SesionController@cerrarSesion");
Route::post('iniciarsesion',"SesionController@iniciarSesion");

/*CLIENT*/
Route::get('busquedataller',"ClienteController@busquedaTaller")->middleware('review');
Route::post('busquedataller',"ClienteController@busquedaTaller2");

Route::get('perfiltaller/{id}',"ClienteController@perfilTaller")->middleware('review');
Route::post('crearevaluacion',"ClienteController@nuevaEvaluacion");

Route::get('evaluacionservicio',"ClienteController@evaluacionesRecomendaciones");
Route::post('evaluacionservicio',"ClienteController@calificacionNuevaEvaluacion");

/*WORKSHOP*/
Route::get('tallertickets',"WorkshopController@userTickets");
Route::get('busquedatickets/{opt}',"WorkshopController@busquedaTickets");
Route::post('cerrarticket',"WorkshopController@cerrarTicket");
Route::get('cargarticket/{id}',"WorkshopController@cargarTicket");

/*APPMOVIL*/
Route::get('marcas',"MovilController@obtenermarcas");
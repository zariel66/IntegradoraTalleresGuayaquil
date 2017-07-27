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

Route::get('/',"HomeController@index")->middleware('guest','nonsecure');
Route::get("registrartaller","HomeController@registrarTaller")->middleware('guest','sslp');
Route::post("registrotallersubmit","HomeController@registrarTallerSubmit")->middleware('guest');
Route::get("registrocliente","HomeController@registrarCliente")->middleware('guest','sslp');
Route::post("registroclientesubmit","HomeController@registrarClienteSubmit")->middleware('guest');
Route::get("serverinfo","HomeController@serverInfo");

/*SESION*/
Route::get('login',"HomeController@login")->middleware('guest','sslp');
Route::get('logout',"SesionController@cerrarSesion")->middleware('myauth');
Route::post('iniciarsesion',"SesionController@iniciarSesion");
Route::get('forgotpassword',"SesionController@forgotPassword")->middleware('guest','nonsecure');
Route::post('forgotpassword',"SesionController@enviarResetToken");
Route::get('nuevopwd/{pass_token}/{correo}',"SesionController@newPassword")->middleware('guest','sslp');
Route::post('nuevopwd',"SesionController@setNewPassword");

/*CLIENT*/

Route::get('busquedataller',"ClienteController@busquedaTaller")->middleware('myauth','acm:2','review','sslp');
Route::post('busquedataller',"ClienteController@busquedaTaller2");
Route::get('perfiltaller/{id}',"ClienteController@perfilTaller")->middleware('myauth','acm:2','review');
Route::post('crearevaluacion',"ClienteController@nuevaEvaluacion");
Route::get('evaluacionservicio',"ClienteController@evaluacionesRecomendaciones")->middleware('myauth');
Route::post('evaluacionservicio',"ClienteController@calificacionNuevaEvaluacion");
Route::get('perfil',"ClienteController@miPerfil")->middleware('myauth','acm:2','review');
Route::post('anadircarro',"ClienteController@anadirCarro")->middleware('myauth','acm:2','review');
Route::post('borrarcarro',"ClienteController@borrarCarro")->middleware('myauth','acm:2','review');

/*WORKSHOP*/
Route::get('tallertickets',"WorkshopController@userTickets")->middleware('myauth','acm:1');
Route::get('busquedatickets/{opt}',"WorkshopController@busquedaTickets");
Route::post('cerrarticket',"WorkshopController@cerrarTicket");
Route::get('cargarticket/{id}',"WorkshopController@cargarTicket");


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

Route::get('/',"HomeController@index")->middleware('guest','sslp');
Route::get("registrartaller","HomeController@registrarTaller")->middleware('guest','sslp');
Route::post("registrotallersubmit","HomeController@registrarTallerSubmit")->middleware('guest');
Route::get("registrocliente","HomeController@registrarCliente")->middleware('guest','sslp');
Route::post("registroclientesubmit","HomeController@registrarClienteSubmit")->middleware('guest');
Route::get("serverinfo","HomeController@serverInfo");
Route::get("tokenplz","HomeController@tokengeneration");
Route::get("register","HomeController@register");
Route::post("editarusuario","HomeController@editarUsuario")->middleware('myauth');

/*SESION*/
Route::get('login',"HomeController@login")->middleware('guest','sslp');
Route::get('logout',"SesionController@cerrarSesion")->middleware('myauth');
Route::post('iniciarsesion',"SesionController@iniciarSesion");
Route::get('forgotpassword',"SesionController@forgotPassword")->middleware('guest');
Route::post('forgotpassword',"SesionController@enviarResetToken");
Route::get('nuevopwd/{pass_token}/{correo}',"SesionController@newPassword")->middleware('guest','sslp');
Route::post('nuevopwd',"SesionController@setNewPassword");
Route::get('confirmarcuenta/{api_token}/{correo}',"SesionController@confirmarCuenta")->middleware('guest','sslp');

/*CLIENT*/

Route::get('busquedataller',"ClienteController@busquedaTaller")->middleware('myauth','acm:2','review','sslp');
Route::post('busquedataller',"ClienteController@busquedaTaller2");
Route::get('perfiltaller/{id}/{latitude?}/{longitude?}/{service?}/{carbrand?}',"ClienteController@perfilTaller")->middleware('myauth','acm:2','review');
Route::post('crearevaluacion',"ClienteController@nuevaEvaluacion");
Route::get('evaluacionservicio',"ClienteController@evaluacionesRecomendaciones")->middleware('myauth');
Route::post('evaluacionservicio',"ClienteController@calificacionNuevaEvaluacion");
Route::get('perfil',"ClienteController@miPerfil")->middleware('myauth','acm:2','review');
Route::post('anadircarro',"ClienteController@anadirCarro")->middleware('myauth','acm:2','review');
Route::post('borrarcarro',"ClienteController@borrarCarro")->middleware('myauth','acm:2','review');
Route::post('editarcarro',"ClienteController@editarCarro")->middleware('myauth','acm:2','review');

/*WORKSHOP*/
Route::get('tallertickets',"WorkshopController@userTickets")->middleware('myauth','acm:1');
Route::get('busquedatickets/{opt}',"WorkshopController@busquedaTickets");
Route::post('cerrarticket',"WorkshopController@cerrarTicket");
Route::get('cargarticket/{id}',"WorkshopController@cargarTicket");
Route::get('perfiltallerowner',"WorkshopController@perfilTaller")->middleware('myauth','acm:1');
Route::get('mostrartaller/{id}',"WorkshopController@mostrarTaller")->middleware('myauth','acm:1');
Route::get('editartaller/{id}',"WorkshopController@editarTaller")->middleware('myauth','acm:1');
Route::post('editartaller/{id}',"WorkshopController@editarTallerSubmit")->middleware('myauth','acm:1');
Route::get('creartaller',"WorkshopController@crearTaller")->middleware('myauth','acm:1');
Route::post('creartallersubmit',"WorkshopController@crearTallerSubmit")->middleware('myauth','acm:1');
Route::get('eliminartaller/{id}',"WorkshopController@eliminarTaller")->middleware('myauth','acm:1');
Route::get('historialtaller',"WorkshopController@historialTaller")->middleware('myauth','acm:1');



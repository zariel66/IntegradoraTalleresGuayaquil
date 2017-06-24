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

Route::get('/',"HomeController@index");
Route::get("registrartaller","HomeController@registrarTaller");
Route::get("registrotallersubmit","HomeController@registrarTallerSubmit");
Route::get("registrocliente","HomeController@registrarCliente");
Route::get("registroclientesubmit","HomeController@registrarClienteSubmit");
Route::get('login',"HomeController@login");
Route::post('iniciarsesion',"SesionController@iniciarSesion");
Route::get('busquedataller',"ClienteController@busquedaTaller");

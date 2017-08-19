<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/marcas', 'MovilController@obtenerMarcas');

Route::post('/vehiculos', 'MovilController@obtenerVehiculos');
Route::post('/registroclientesubmit', 'MovilController@registrarCliente');
Route::post('/registrotallersubmit', 'MovilController@registrarTaller');
Route::post('/iniciarsesion', 'MovilController@iniciarSesion');
Route::post('/busquedataller', 'MovilController@busquedaTaller');
Route::post('/perfiltaller/{id_taller}', 'MovilController@perfilTaller');
Route::post('/nuevaevaluacion/{id_taller}', 'MovilController@nuevaEvaluacion');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovilController extends Controller
{
     public function obtenermarcas()
	{
		
		return response()->json(Marca::all());
	}



	public function ingresarclientes()
	{
		
		DB::beginTransaction();
		try {
			$idusuario = DB::table('usuario')->insertGetId(
				array(

					'nombre' => Input::get('nombre'),
					'apellido' => Input::get('apellido'),
					'correo' => Input::get('correo'),
					'password' => bcrypt(Input::get('password')),
					'tipo' => 2,
					'username' => Input::get('username')
					)
				);
			$idvehiculo = DB::table('vehiculo')->insertGetId(
				array(

					'idmarca' => Input::get('marca'),
					'idusuario' => $idusuario,
					'modelo' => Input::get('modelo'),
					
					)
				);
			error_log($idusuario);
			error_log($idvehiculo);
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;	
		}
	}
}

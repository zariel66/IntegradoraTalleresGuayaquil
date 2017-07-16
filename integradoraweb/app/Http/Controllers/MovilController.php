<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Controllers\Controller;
use App\Marca;
use App\Taller;
use App\Calificacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovilController extends Controller
{
    public function obtenermarcas()
	{
		
		return response()->json(Marca::all());
	}


    public function camposobligatorios()
    {

       $rules = array(
			'nombre' => 'required|regex:/(^[A-Za-z ]+$)+/|min:3',
			'apellido' => 'required|regex:/(^[A-Za-z ]+$)+/|min:3',
			'username' => 'required|unique:usuario,username|min:5',
			'correo' => 'required|unique:usuario,correo|email',
			'password' => 'required|min:8'
			); 


		$custom = array(
			"nombre.required" => "El :attribute es requerido",
			"apellido.required" => "El :attribute es requerido",
			"username.required" => "El usuario es requerido",
			"password.required" => "La contraseña es requerida",
			"correo.required" => "El :attribute es requerido",
			
			"username.unique" => "El usuario ingresado ya existe, elija otro",
			"correo.unique" => "El :attribute ingresado ya se encuentra en uso, elija otro",

			"correo.email" => "Ingrese una dirección de correo válida",

			
			"nombre.regex" => "El :attribute solo debe contener texto",
			"apellido.regex" => "El :attribute solo debe contener texto",

			"nombre.min" => "El :attribute debe tener mínimo :min caracteres",
			"apellido.min" => "El :attribute debe tener mínimo :min caracteres",
			"username.min" => "El :attribute debe tener mínimo :min caracteres",
			"password.min" => "La contraseña debe tener mínimo :min caracteres",
			
			);
		$validation = Validator::make(Input::all(),$rules,$custom);

		if ($validation->fails())
		{

			return response()->back()->withErrors($validator)->withInput();
			
		}
	}
     

	public function ingresarclientes(Request $request)
	{
		/*$rules = array(
			
			"marca" => 'required',
			'modelo' => "required",
			); 


		$custom = array(
			
     		"marca.required" => "La :attribute es requerida",
			"modelo.required" => "La :attribute del vehículo es requerido",
			
			);
		
		$validation = Validator::make(Input::all(),$rules,$custom);

		if ($validation->fails())
		{
			error_log("entro controller 3");
			return Redirect::back()->withErrors($validation)->withInput(Input::all());
		}*/
		
		DB::beginTransaction();
		try {
			$idusuario = DB::table('usuario')->insertGetId(
				array(

					'nombre' => Input::get('nombre'),
					'apellido' => Input::get('apellido'),
					'tipo' => 2,
					'username' => Input::get('username'),
					'password' => bcrypt(Input::get('password')),
					'correo' => Input::get('correo')
					
					)
				);
			$idvehiculo = DB::table('vehiculo')->insertGetId(
				array(

					'idmarca' => Input::get('marca'),
					'idusuario' => $idusuario,
					'modelo' => Input::get('modelo')					
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

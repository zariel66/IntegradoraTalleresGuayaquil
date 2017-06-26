<?php

namespace App\Http\Controllers;
use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Controllers\Controller;
use App\Marca;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;


class HomeController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest');
    }
	public function index()
	{
		return view("basic.home");
	}

	public function registrarTaller()
	{    
		$marcas = DB::table('marca')->orderBy("nombre","ASC")->get();
		return view("basic.registerworkshop",array('marcas' => $marcas ));
	}

	public function registrarTallerSubmit()
	{
		$rules = array(
			'nombre' => 'required|regex:/(^[A-Za-z ]+$)+/|min:3',
			'apellido' => 'required|regex:/(^[A-Za-z ]+$)+/|min:3',
			'username' => 'required|unique:usuario,username|min:5',
			'correo' => 'required|unique:usuario,correo|email',
			'password' => 'required|min:8',
			'password_confirmation' => 'same:password',
			'direccion' => 'required|min:10',
			'telefono' => 'required|min:6',
			'nombre_empleado' => 'required|min:10',
			"marcas" => 'required|array|min:1',
			"servicios" => 'required|array|min:1',
			"nombre_taller" => "required|min:6"
			); 


		$custom = array(
			"nombre.required" => "El :attribute es requerido",
			"apellido.required" => "El :attribute es requerido",
			"username.required" => "El usuario es requerido",
			"password.required" => "La contraseña es requerida",
			"correo.required" => "El :attribute es requerido",
			"telefono.required" => "El teléfono es requerido",
			"direccion.required" => "La dirección es requerida",
			"nombre_empleado.required" => "El nombre del empleado es requerido",
			"marcas.required" => "Debe seleccionar al menos una marca de vehículo con la que trabaja",
			"servicios.required" => "Debe seleccionar al menos un servicio que ofrece en su taller",
			"nombre_taller.required" => "El nombre del taller es requerido",

			"username.unique" => "El usuario ingresado ya existe, elija otro",
			"correo.unique" => "El :attribute ingresado ya se encuentra en uso, elija otro",

			"correo.email" => "Ingrese una dirección de correo válida",

			"password.confirmed" => "La contraseña debe ser confirmada",
			"password_confirmation.same" => "Las contraseñas deben coincidir",

			"nombre.regex" => "El :attribute solo debe contener texto",
			"apellido.regex" => "El :attribute solo debe contener texto",

			"nombre.min" => "El :attribute debe tener mínimo :min caracteres",
			"apellido.min" => "El :attribute debe tener mínimo :min caracteres",
			"username.min" => "El :attribute debe tener mínimo :min caracteres",
			"password.min" => "La contraseña debe tener mínimo :min caracteres",
			"telefono.min" => "El teléfono debe tener mínimo :min caracteres",
			"direccion.min" => "La dirección debe tener mínimo :min caracteres",
			"nombre_empleado.min" => "El nombre del empleado debe tener mínimo :min caracteres",


			);
		$validation = Validator::make(Input::all(),$rules,$custom);

		if ($validation->fails())
		{

			return Redirect::back()->withErrors($validation)->withInput(Input::all());
		}

		DB::beginTransaction();
		try {
			$idusuario = DB::table('usuario')->insertGetId(
				array(

					'nombre' => Input::get('nombre'),
					'apellido' => Input::get('apellido'),
					'correo' => Input::get('correo'),
					'password' => bcrypt(Input::get('password')),
					'tipo' => 1,
					'username' => Input::get('username')
					)
				);

			$idtaller = DB::table('taller')->insertGetId(
				array(

					'latitud' => Input::get('lat'),
					'longitud' => Input::get('lon'),
					'direccion' => Input::get('direccion'),
					'idusuario' => $idusuario,
					'nombre_empleado' => Input::get('nombre_empleado'),
					'telefono' => Input::get('telefono'),
					"nombre_taller" => Input::get('nombre_taller'),
					)
				);
			foreach (Input::get('marcas') as $marca)
			{
				$id_marca_taller = DB::table('marca_taller')->insertGetId(
					array(
						"idmarca" => $marca,
						"idtaller" => $idtaller
						));
		
			}
			foreach (Input::get('servicios') as $servicio)
			{
				$id_servicio_taller = DB::table('servicio_taller')->insertGetId(
					array(
						"categoria" => $servicio,
						"idtaller" => $idtaller
						));
		
			}

		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
		DB::commit();


		return "TALLER CREADO EXITOSAMENTE CON ID" ;



	}

	public function registrarCliente()
	{    
		$marcas = DB::table('marca')->orderBy("nombre","ASC")->get();
		return view("basic.registerclient",array('marcas' => $marcas ));
	}


	public function registrarClienteSubmit(Request $request)
	{    
		error_log("entro controller");
		$rules = array(
			'nombre' => 'required|regex:/(^[A-Za-z ]+$)+/|min:3',
			'apellido' => 'required|regex:/(^[A-Za-z ]+$)+/|min:3',
			'username' => 'required|unique:usuario,username|min:5',
			'correo' => 'required|unique:usuario,correo|email',
			'password' => 'required|min:8',
			'password_confirmation' => 'same:password',
			"marca" => 'required',
			'modelo' => "required",
			); 


		$custom = array(
			"nombre.required" => "El :attribute es requerido",
			"apellido.required" => "El :attribute es requerido",
			"username.required" => "El usuario es requerido",
			"password.required" => "La contraseña es requerida",
			"correo.required" => "El :attribute es requerido",
			"marca.required" => "La :attribute es requerida",
			"modelo.required" => "La :attribute del vehículo es requerido",

			"username.unique" => "El usuario ingresado ya existe, elija otro",
			"correo.unique" => "El :attribute ingresado ya se encuentra en uso, elija otro",
			"correo.email" => "Ingrese una dirección de correo válida",

			"password.confirmed" => "La contraseña debe ser confirmada",
			"password_confirmation.same" => "Las contraseñas no coinciden",

			"nombre.regex" => "El :attribute solo debe contener texto",
			"apellido.regex" => "El :attribute solo debe contener texto",

			"nombre.min" => "El :attribute debe tener mínimo :min caracteres",
			"apellido.min" => "El :attribute debe tener mínimo :min caracteres",
			"username.min" => "El :attribute debe tener mínimo :min caracteres",
			"password.min" => "La contraseña debe tener mínimo :min caracteres",
			


			);
		error_log("entro controller 2");
		$validation = Validator::make(Input::all(),$rules,$custom);

		if ($validation->fails())
		{
			error_log("entro controller 3");
			return Redirect::back()->withErrors($validation)->withInput(Input::all());
		}

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

		DB::commit();
		if(Auth::attempt(['username' =>  Input::get('username'), 'password' => Input::get('password')]))
			return redirect("busquedataller");
		else
			return "failed login";


	}

	public function login()
	{
		return view("basic.login");
	}
}

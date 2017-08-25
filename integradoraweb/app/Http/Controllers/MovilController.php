<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Marca;
use App\Taller;
use App\Calificacion;
use App\Vehiculo;


class MovilController extends Controller
{
  public function obtenerMarcas()
	{
		return response()->json(Marca::all());
  }

  public function obtenerVehiculos()
  {
    $vehiculos = array();
    $token = Input::get('api_token');
    $msg = '';

    if ($token)
    {
      try {
        $user = User::where('api_token', $token)->firstOrFail();
        $user_vehiculos = $user->vehiculos;

        if (!$user_vehiculos) $msg = 'No se encontraron vehiculos';
        else {
          foreach ($user_vehiculos as $uv) {
            $marca = Marca::find($uv->idmarca);

            $vehiculo = array(
              'id' => $uv->id,
              'modelo' => $uv->modelo,
              'marca' => $marca
            );

            array_push($vehiculos, $vehiculo);
          }
        }
      } catch (\Exception $e) {}

    }

    return response()->json([
      'is_error' => false,
      'msg' => $msg,
      'data' => $vehiculos
    ]);

	}

  public function registrarCliente()
  {
    $rules = array(
      'nombre' => 'required|regex:/(^[A-Za-záéíóú ]+$)+/|min:3',
      'apellido' => 'required|regex:/(^[A-Za-záéíóú ]+$)+/|min:3',
      'username' => 'required|unique:usuario,username|min:5',
      'correo' => 'required|unique:usuario,correo|email',
      'password' => 'required|min:8',
      'password_confirmation' => 'same:password',
      'vehiculos' => 'required',
    );

    $custom = array(
      "nombre.required" => "El :attribute es requerido",
      "apellido.required" => "El :attribute es requerido",
      "username.required" => "El usuario es requerido",
      "password.required" => "La contraseña es requerida",
      "correo.required" => "El :attribute es requerido",
      "vehiculos.required" => "El :attribute es requerido",

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

    $validation = Validator::make(Input::all(),$rules,$custom);

    if ($validation->fails())
    {
      return response()->json([
        'is_error' => true,
        'msg' => $validation->errors()->first()
      ]);
    }

    $api_token = str_random(60);
    $input = array('api_token' => $api_token );
    $vehicle = Input::get('vehiculos')[0];
    $user = array();

    DB::beginTransaction();
    try {

      $idusuario = DB::table('usuario')->insertGetId(
        array(
          'nombre' => Input::get('nombre'),
          'apellido' => Input::get('apellido'),
          'correo' => Input::get('correo'),
          'password' => bcrypt(Input::get('password')),
          'tipo' => 2,
          'username' => Input::get('username'),
          'api_token' => $api_token
        )
      );

      $idvehiculo = DB::table('vehiculo')->insertGetId(
        array(
          'idmarca' => $vehicle['marca']['id'],
          'idusuario' => $idusuario,
          'modelo' => $vehicle['modelo']
        )
      );

      // Build user
      $user = array(
        'id' => $idusuario,
        'nombre' => Input::get('nombre'),
        'apellido' => Input::get('apellido'),
        'correo' => Input::get('correo'),
        'tipo' => 2,
        'username' => Input::get('username'),
        'api_token' => $api_token,
        'vehiculos' => array($vehicle)
      );


    } catch (\Exception $e) {
      DB::rollback();
      //return response()->json(['error' => $e->getMessage(), 'v' => $vehicle['marca']['id']]);
      abort(500);
    }

    DB::commit();
    return response()->json([
      'is_error' => false,
      'msg' => 'Cliente registrado correctamente',
      'data' => $user
    ]);
  }

  public function registrarTaller()
  {
    $rules = array(
      'nombre' => 'required|regex:/(^[A-Za-záéíóú ]+$)+/|min:3',
      'apellido' => 'required|regex:/(^[A-Za-záéíóú ]+$)+/|min:3',
      'username' => 'required|unique:usuario,username|min:5',
      'correo' => 'required|unique:usuario,correo|email',
      'password' => 'required|min:8',
      'password_confirmation' => 'same:password',
      'direccion' => 'required|min:10',
      'telefono' => 'required|min:6',
      'nombre_empleado' => 'required|min:10',
      'marcas' => 'required',
      'servicios' => 'required',
      'nombre_taller' => "required|min:3",
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
      "nombre_taller.required" => "El nombre del taller es requerido",
      "marcas.required" => "Debe seleccionar al menos una marca de vehículo con la que trabaja",
      "servicios.required" => "Debe seleccionar al menos un servicio que ofrece en su taller",

      "username.unique" => "El usuario ingresado ya existe, elija otro",
      "correo.unique" => "El :attribute ingresado ya se encuentra en uso, elija otro",

      "correo.email" => "Ingrese una dirección de correo válida",

      "password.confirmed" => "La contraseña debe ser confirmada",
      "password_confirmation.same" => "Las contraseñas deben coincidir",

      "nombre.regex" => "El :attribute solo debe contener texto",
      "apellido.regex" => "El :attribute solo debe contener texto",
      "username.regex" => "El nombre de usuario debe comenzar con una letra seguido de caracteres alfanuméricos",

      "nombre.min" => "El :attribute debe tener mínimo :min caracteres",
      "apellido.min" => "El :attribute debe tener mínimo :min caracteres",
      "username.min" => "El usuario debe tener mínimo :min caracteres",
      "password.min" => "La contraseña debe tener mínimo :min caracteres",

      "telefono.min" => "El teléfono debe tener mínimo :min caracteres",
      "direccion.min" => "La dirección debe tener mínimo :min caracteres",
      "nombre_empleado.min" => "El nombre del empleado debe tener mínimo :min caracteres",
      "nombre_taller.min" => "El nombre del taller debe tener mínimo :min caracteres",
    );

    $validation = Validator::make(Input::all(),$rules,$custom);

    if ($validation->fails())
    {
      return response()->json([
        'is_error' => true,
        'msg' => $validation->errors()->first()
      ]);
    }

    $api_token = str_random(60);
    $input = array('api_token' => $api_token );

    DB::beginTransaction();
    try {

      $idusuario = DB::table('usuario')->insertGetId(
        array(
          'nombre' => Input::get('nombre'),
          'apellido' => Input::get('apellido'),
          'correo' => Input::get('correo'),
          'password' => bcrypt(Input::get('password')),
          'tipo' => 1,
          'username' => Input::get('username'),
          'api_token' => $api_token
        )
      );

      $idtaller = DB::table('taller')->insertGetId(
        array(
          'latitud' => Input::get('latitud'),
          'longitud' => Input::get('longitud'),
          'direccion' => Input::get('direccion'),
          'idusuario' => $idusuario,
          'nombre_empleado' => Input::get('nombre_empleado'),
          'telefono' => Input::get('telefono'),
          'nombre_taller' => Input::get('nombre_taller'),
        )
      );

      foreach (Input::get('marcas') as $marca)
      {
        $id_marca_taller = DB::table('marca_taller')->insertGetId(
          array(
            'idmarca' => $marca['id'],
            'idtaller' => $idtaller
          )
        );
      }

      foreach (Input::get('servicios') as $servicio)
      {
        $id_servicio_taller = DB::table('servicio_taller')->insertGetId(
          array(
            'categoria' => $servicio['nombre'],
            'idtaller' => $idtaller
          )
        );
      }

    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['error' => $e->getMessage()]);
      //abort(500);
    }

    DB::commit();
    return response()->json([
      'is_error' => false,
      'msg' => 'Taller registrado correctamente'
    ]);
  }

  public function iniciarSesion()
  {

    $username = Input::get('username');
    $password = Input::get('password');

    try {
      if (Auth::attempt(['username' => $username, 'password' => $password]))
      {
        $user = Auth::user();
        return response()->json([
          'is_error' => false,
          'msg' => 'Inicio de sesion exitoso',
          'data' => $user
        ]);
      }
      return response()->json([
        'is_error' => false,
        'msg' => 'Usuario o contrasena invalido'
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'is_error' => true,
        'msg' => $e->getMessage()
      ]);
    }
  }


	public function busquedaTaller()
  {
    $msg = '';
    $isError = false;
		$servicio = Input::get('servicio');
		$marca =  Input::get('marca');
		$latitude = Input::get('latitud');
		$longitude =  Input::get('longitud');
    $distancia =  Input::get('distancia');

    $query = "select distinct t.*,6371*2*asin( sqrt( power(sin(((". $latitude ." - t.latitud) * pi()/180) / 2),2)  + cos(". $latitude ." * pi()/180) * cos( t.latitud  *  pi()/180) * power( sin( (". $longitude ." - t.longitud) * pi()/180),2 )) ) as distance from taller as t INNER JOIN servicio_taller as st ON t.id = st.idtaller INNER JOIN marca_taller as mt ON mt.idtaller=t.id INNER JOIN marca as m on mt.idmarca = m.id where st.categoria = '". $servicio ."' and mt.idmarca = ". $marca ." having distance< ". $distancia ." ORDER BY distance limit 10";

    $workshops = DB::select($query);

    if (!$workshops) {
      $isError = true;
      $msg = 'No se encontraron talleres cercanos ';
    }

    return response()->json([
      'is_error' => $isError,
      'msg' => $msg,
      'data' => $workshops
    ]);
  }


	public function perfilTaller($id_taller)
  {
    try {
      $token = Input::get('api_token');

      $user = User::where('api_token', $token)->firstOrFail();
      $taller =  Taller::find($id_taller);

			if(!is_null($taller))
      {
        $servicios = $taller->servicios;
        $marcas = $taller->marcas;
        $code = $taller->calificaciones->where('estado', 0)->where('idusuario',$user->id)->first()->desc_code;
        $comentarios = $taller->calificaciones()->where('estado', 1)->orderBy('fecha_hora', 'desc');

        $taller['servicios'] = $servicios;
        $taller['marcas'] = $marcas;
        $taller['code'] = $code;
        $taller['evaluaciones'] = $comentarios;
			}

      return response()->json([
        'is_error' => false,
        'data' => $taller
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'is_error' => true,
        'msg' => $e->getMessage()
      ]);
		}

  }

	public function nuevaEvaluacion($id_taller)
	{
		$desc_code = str_random(8);
    try {
      $token = Input::get('api_token');
      $user = User::where('api_token', $token)->firstOrFail();

			$id = DB::table('calificacion')->insertGetId(
		    ['idusuario' => $user->id,
		     'idtaller' => $id_taller,
		     'estado' => 0,
		     'desc_code' => $desc_code,
		     'fecha_hora' => \Carbon\Carbon::now()
		    ]
      );

      return response()->json([
        'is_error' => false,
        'msg' => 'Visita creada correctamente'
      ]);

    } catch (\Exception $e) {
      return response()->json([
        'is_error' => true,
        'msg' => $e->getMessage()
      ]);
		}
	}



}

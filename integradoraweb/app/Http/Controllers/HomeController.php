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

class HomeController extends Controller
{
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
            'nombre' => 'required|alpha',
            'apellido' => 'required|alpha',
            'username' => 'required|unique:usuario,username',
            'correo' => 'required|unique:usuario,correo|email',
            'password' => 'required',
            'password_confirmation' => 'same:password',
            'direccion' => 'required',
            'telefono' => 'required',
            'nombre_empleado' => 'required',
            ); 
        
        
        $custom = array(
            "nombre.required" => "El :attribute es requerido",
            "apellido.required" => "El :attribute es requerido",
            "username.required" => "El usuario es requerido",
            "apellido.required" => "El :attribute es requerido",
            "password.required" => "La contraseña es requerida",
            "correo.required" => "El :attribute es requerido",
            "telefono.required" => "El teléfono es requerido",
            "direccion.required" => "La dirección es requerida",
            "nombre_empleado.required" => "El nombre del empleado es requerido",
            "username.unique" => "El usuario ingresado ya existe, elija otro",
            "correo.unique" => "El :attribute se encuentra en uso, elija otro",
            "correo.email" => "Ingrese una dirección de correo válida",
            "password.confirmed" => "La contraseña debe ser confirmada",
            "password_confirmation.same" => "Las contraseñas deben coincidir",
            "nombre.alpha" => "El :attribute solo debe contener texto",
            "apellido.alpha" => "El :attribute solo debe contener texto",
        );
        $validation = Validator::make(Input::all(),$rules,$custom);
           
        if ($validation->fails())
        {
            
            return Redirect::back()->withErrors($validation)->withInput(Input::all());
        }
    try {
        $id = DB::table('usuario')->insertGetId(
        array(
            
            'nombre' => Input::get('nombre'),
            'apellido' => Input::get('apellido'),
            'correo' => Input::get('correo'),
            'password' => bcrypt(Input::get('password')),
            'tipo' => 1,
            'username' => Input::get('username')
            )
        );
        return $id;
        
    } catch (QueryException $e) {
        error_log("query exception: possible duplicate constraint");
        return "error query";
        
    }
        
   }
}
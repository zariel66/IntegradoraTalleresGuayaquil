<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
class SesionController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    

    public function iniciarSesion()
    {
        
        if (Auth::attempt(['username' =>  Input::get('username'), 'password' => Input::get('password')])) {
            // Authentication passed...
            //return redirect()->intended('dashboard');
            $user = Auth::user();
            if($user->tipo == 2)
            {
                return redirect()->intended('busquedataller');
            }
            else if($user->tipo == 1)
            {
                return redirect()->intended('tallertickets');
            }
            else if($user->tipo == 3 or $user->tipo == 4)
            {
                Auth::logout();
                session()->flush();
                return redirect("login")->with("mensajet3","La cuenta ingresada no ha sido confirmada. Ingrese a su correo para activar su cuenta.");
            }
            
        }
        return redirect("login")->with("mensajet3","Las credenciales proporcionadas son incorrectas");
    }

    public function cerrarSesion()
    {
        Auth::logout();
        session()->flush();
        return redirect("login");
    }

    public function forgotPassword()
    {
        return view("basic.forgotpassword");
    }

    public function enviarResetToken()
    {
        $correo = Input::get('correo');
        $reglas  = array('correo' => "required|email|exists:usuario,correo" );
        $mensaje = array(
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El campo ingresado debe ser un correo válido',
            'correo.exists' => 'El correo ingresado no se encuentra registrado',
            );
        $validation = Validator::make(Input::all(),$reglas,$mensaje);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        try {
            $user = User::where("correo",$correo)->first();
            if($user->tipo == 3 or $user->tipo == 4)
            {
                return redirect("login")->with("mensajet3","La cuenta ingresada no ha sido validada. Ingrese a su correo y confirme su registro.");        
            }
            
            $user->update(
            [
                'pass_token' => str_random(10)
            ]);
            Mail::send('emails.passrecovery', ['user' => $user], function ($m) use ($user) {
                $m->from(config("constants.emails.from"), config("constants.app_name"));

                $m->to($user->correo, $user->nombre)->subject('Restablecer Contraseña');
            });
            return view("basic.login")->with(array("mensajet1"=>"Se ha enviado un enlace para restablecer la contraseña a su correo"));
            
        } catch (\Exception $e) {
            throw $e;
            
        }
    }

    public function newPassword($pass_token,$correo)
    {
        try {

            $user = User::where("correo",$correo)->where('pass_token',$pass_token);
            //var_dump($user->first());
            // error_log("CONTADOR: " . count($user));
            // error_log("id: " . $user->first()->id);
            if(is_null($user->first()))
            {
                throw new \Exception("Error Updating on null", 1);    
            }
            
            
        } catch (\Exception $e) {
            return view("basic.login")->with(array("mensajet2"=>"El enlace es incorrecto o ya ha caducado"));
        }
        
        return view("basic.newpwd",["pass_token"=>$pass_token,"correo"=> $correo]);
    }

    public function setNewPassword()
    {
        try {
            $reglas = array(
                'password' => 'required|min:8',
                'repeat_password' => 'same:password',
                
                );
            $mensaje = array(
                "password.required" => "Ambos campos son requeridos y deben coincidir",
                "repeat_password" => "Ambos campos son requeridos y deben coincidir",
                "password.min" => "La contraseña debe tener mínimo :min caracteres",
                );
            $validation = Validator::make(Input::all(),$reglas,$mensaje);

            if($validation->fails()) {
                return Redirect::back()->withErrors($validation);
            }
            $user = User::where("correo",Input::get('correo'))->where('pass_token',Input::get('pass_token'))->first();
            if(!is_null($user))
            {
                $user->update(
                [
                    'pass_token' => str_random(10),
                    'password' => bcrypt(Input::get('password'))
                ]);    
            }
            else
            {
                throw new \Exception("Error Updating on null", 1);
                                
            }     
        } catch (\Exception $e) {
            return Redirect::back();
        }
        return view("basic.login")->with(array("mensajet1"=>"La contraseña se ha restablecido"));
        
    }

    public function confirmarCuenta($api_token,$correo)
    {
         try {

            $user = User::where("correo",$correo)->where('api_token',$api_token)->first();
          
            if(is_null($user))
            {
                abort(404);    
            }
            if($user->tipo == 3)
            {
                $user->update(
                [
                    "tipo" => 1
                ]);  
            }
            else if($user->tipo == 4)
            {
                $user->update(
                [
                    "tipo" => 2
                ]);  
            }
            return redirect("login")->with("mensajet1","Su cuenta ha sido activada. Ingrese con sus credenciales.");
        } catch (\Exception $e) {
            abort(500);
        }
        
        
    }
}
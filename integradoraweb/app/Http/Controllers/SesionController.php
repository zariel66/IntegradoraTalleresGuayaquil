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
            
        }
        return redirect("login");
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
            $user = User::where("correo",$correo)->where('pass_token',$pass_token)->first();
            $user->update(
            [
                'pass_token' => str_random(10)
            ]);
        } catch (\Exception $e) {
            return view("basic.login")->with(array("mensajet2"=>"El enlace ya ha caducado"));
        }
        
        return "token: " . $pass_token . "\ncorreo: " . $correo; 
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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
            if($user->tipo== 2)
            {
                return redirect("busquedataller");
            }

// Get the currently authenticated user's ID...
            
        }
        return redirect("login");
    }

    public function cerrarSesion()
    {
        Auth::logout();
        return redirect("/");
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class AccessControl
{
    

    public function handle($request, Closure $next, $tipo)
    {
        
        if(Auth::user()->tipo != $tipo)
        {
            return redirect("logout");
        }           
        return $next($request);
    }
}

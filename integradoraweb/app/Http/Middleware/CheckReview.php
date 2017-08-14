<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckReview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        error_log($request->session()->has('pendingreview'));
        if ($request->session()->has('pendingreview') == false) {
            $user = Auth::user();
            $pendingreview = count($user->calificaciones->where("estado",2));
            error_log("UNIT TEST: Reviews pendientes-> " . $pendingreview);
            session(['pendingreview' => $pendingreview]);
            if($pendingreview > 0)
            {
                return redirect("evaluacionservicio");
            }
        }
        else if($request->session()->get('pendingreview') > 0)
        {
            return redirect("evaluacionservicio");
        }
        
        return $next($request);
    }
}

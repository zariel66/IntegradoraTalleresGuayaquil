<?php namespace App\Http\Middleware;

use Closure;

class Nonsecure {

    public function handle($request, Closure $next)
    {
    	if ($request->secure()) {
    		
    		return redirect(str_replace('https','http',$request->url()));
    	}
    	return $next($request); 
    }
}

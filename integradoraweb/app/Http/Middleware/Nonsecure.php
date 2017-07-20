<?php namespace App\Http\Middleware;

use Closure;

class Nonsecure {

    public function handle($request, Closure $next)
    {
    	if ($request->secure()) {
    		//return Redirect::to('http://' . Request::url());
    		return redirect('http://' . $request->url());
    	}
    	return $next($request); 
    }
}

<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;

class AdminMiddleware
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
       if(Auth::check() && session("role_id")==2)
		{
			return $next($request);
		}
		else
		{
            
			return redirect("/")->with('check_login_message',"Please Login Your Account First!...");
		}
    }
}

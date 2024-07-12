<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class SuperAdminMiddleware
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
        if(Auth::check() && session("role_id")==1)
		{
			return $next($request);
		}
		else
		{
            return redirect("/")->with('check_login_message',"Please Login Your Account First!...");
		}
    }
}

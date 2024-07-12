<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LoginStatusCheckMiddleware
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
        if(Auth::check() && session('role_id') == 1){
                
            return redirect("/super_admin/dashboard");

        }elseif(Auth::check() && session('role_id') == 2 && session("myuser_schools")){

            return redirect("/admin/dashboard");

        }elseif(Auth::check() && session('role_id') == 3 && session("myuser_schools")){

            return redirect("/teacher/dashboard");

        }else{
            
            return $next($request);
        }
    }

    

}

<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Config;

class LoginAuthenticate
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
        
        if (Auth::check()) 
        { 
            
            if(auth()->user()->role_id == Config('constants.roles.Admin') || auth()->user()->role_id == Config('constants.roles.SuperAdmin'))
            {
                return redirect('admin/dashboard');
            }
        }else{
            return $next($request);
        }
            
    }



}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use User;


class RestrictAccess
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
        //verificam daca userul este autentificat si daca este admin
        if (Auth::check() && Auth::user()->isAdmin()){
            return $next($request);
        }
        return redirect("/login");

    }
}

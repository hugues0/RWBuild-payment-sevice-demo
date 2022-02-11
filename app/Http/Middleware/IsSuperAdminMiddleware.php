<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isSuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //redirects a guest to login screen
        if(!auth()->check()){
            return redirect(route('login'));
        }

        //check if logged in user is super admin
        if(!auth()->user()->isSuperAdmin()){
            abort(403);
        }
        return $next($request);
    }
}

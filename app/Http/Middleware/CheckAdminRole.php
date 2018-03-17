<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckAdminRole
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()['role'] == 'admin') {

            return $next($request);
        } else {

            return redirect('/');
        }
    }
}

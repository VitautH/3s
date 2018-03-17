<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckUserRole
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()['role'] == 'user') {
            return $next($request);
        } else {
            return redirect('/admin');
        }
    }
}
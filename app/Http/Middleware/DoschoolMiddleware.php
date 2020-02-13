<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class DoschoolMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->group_id == 6) {
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}

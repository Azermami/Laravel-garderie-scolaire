<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfPersonnel
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->id_role == 3) {
            return $next($request);
        }

        return redirect('/');
    }
}

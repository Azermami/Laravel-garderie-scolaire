<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
public function handle(Request $request, Closure $next)
{
    if (Auth::check() && Auth::user()->id_role == 1) { // Supposons que 1 est le rôle d'administrateur
        return $next($request);
    }

    return redirect('/'); // Redirige si l'utilisateur n'est pas un admin
}
}



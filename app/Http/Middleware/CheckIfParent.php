<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfParent
{
    public function handle($request, Closure $next)
    {
        \Log::info('CheckIfParent middleware triggered.');

        if (Auth::check()) {
            \Log::info('User is authenticated.');
            if (Auth::user()->isParent()) {
                \Log::info('User is a parent.');
                return $next($request);
            } else {
                \Log::info('User is not a parent.');
            }
        } else {
            \Log::info('User is not authenticated.');
        }

        return redirect()->route('login')->withErrors(['msg' => 'Accès réservé aux parents.']);
    }
}

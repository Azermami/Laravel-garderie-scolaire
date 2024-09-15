<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfParentValidated
{
    public function handle($request, Closure $next)
    {
        \Log::info('CheckIfParentValidated middleware triggered.');

        if (Auth::check()) {
            \Log::info('User is authenticated.');
            if (Auth::user()->isParent()) {
                \Log::info('User is a parent.');
                if (Auth::user()->isValidated()) {
                    \Log::info('Parent account is validated.');
                    return $next($request);
                } else {
                    \Log::info('Parent account is not validated.');
                }
            } else {
                \Log::info('User is not a parent.');
            }
        } else {
            \Log::info('User is not authenticated.');
        }

        return redirect()->route('login')->withErrors(['msg' => 'Votre compte doit être validé par un administrateur.']);
    }
}

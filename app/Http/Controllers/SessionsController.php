<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
   
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:parent,personnel',
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($role == 'parent' && $user->isParent()) {
                if ($user->isValidated()) {
                    return redirect()->intended('/parent/dashboard');
                } else {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Votre compte doit être validé par un administrateur.']);
                }
            } elseif ($role == 'personnel' && $user->id_role == 3) {
                return redirect()->intended('/personnel/dashboard');
            } else {
                Auth::logout();
                return back()->withErrors(['role' => 'Role non valide pour cet utilisateur.']);
            }
        }

        return back()->withErrors(['email' => 'Les informations fournies sont incorrectes.']);
    }

    public function createAdmin()
    {
        return view('auth.admin-login');
    }

    public function storeAdmin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Vous n\'avez pas les droits d\'administrateur.']);
        }

        return back()->withErrors(['email' => 'Les informations fournies sont incorrectes.']);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Vous avez été déconnecté.');
    }
    
}


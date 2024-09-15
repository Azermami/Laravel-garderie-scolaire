<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nom' => ['required', 'max:50'],
            'prenom' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'pwd' => ['required', 'min:5', 'max:20', 'confirmed'],
        ]);

        $attributes['pwd'] = Hash::make($attributes['pwd']);
        $attributes['etat'] = true; // ou toute autre valeur par défaut appropriée
        $attributes['id_role'] = 1; // ou toute autre valeur par défaut appropriée

        $user = User::create($attributes);
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Votre compte a été créé avec succès.');
    }
}



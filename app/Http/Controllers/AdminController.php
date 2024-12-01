<?php 
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        // Fetch counts for the dashboard
        $adminCount = User::where('id_role', 1)->count();
        $verifiedParentCount = User::where('id_role', 2)->where('etat', 1)->count();
        $pendingParentCount = User::where('id_role', 2)->where('etat', 0)->count();
        $personnelCount = User::where('id_role', 3)->count();

        // Pass the data to the view
        return view('admin.dashboard', compact('adminCount', 'verifiedParentCount', 'pendingParentCount', 'personnelCount'));
    }
    
    public function validateParent($id)
{
    $parent = Parent::find($id);
    $parent->etat = 1;
    $parent->save();

    return redirect()->back()->with('success', 'Le parent a été validé avec succès.');
}


    public function createPersonnel()
    {
        return view('admin.add-personnel');
        
    }

    public function storePersonnel(Request $request)
    {
        $attributes = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Convert the 'password' field to 'pwd'
        $attributes['pwd'] = Hash::make($attributes['password']);
        $attributes['id_role'] = 3; // Assign role id 3 for personnel
        $attributes['etat'] = true; // Or any default value you prefer
    
        User::create($attributes);
    
        return redirect()->route('admin.createPersonnel')->with('success', 'Personnel added successfully.');
    }

    public function showLoginForm()
{
    return view('auth.admin-login');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->isAdmin()) { // Assurez-vous d'avoir cette méthode dans votre modèle User
            return redirect()->intended(route('admin.dashboard'));
        } else {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['msg' => 'Accès réservé aux administrateurs.']);
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


    
}

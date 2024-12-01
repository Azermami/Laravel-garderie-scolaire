<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PersonnelController extends Controller
{
    
    public function dashboard()
    {
        return view('personnel.dashboard');
    }

    public function index()
    {
        // Récupérer tous les utilisateurs avec le rôle de personnel (id_role = 3)
       // $personnels = User::where('id_role', 3)->get();
        $personnels = User::where('id_role', 3)->paginate(10);
        // Passer les données à la vue
        return view('personnel.index', compact('personnels'));
    }
    



    public function create()
    {
        return view('admin.add-personnel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $personnel = new User();
        $personnel->nom = $request->input('nom'); // Utilisez 'nom' au lieu de 'name'
        $personnel->prenom = $request->input('prenom'); // Utilisez 'prenom' au lieu de 'name'
        $personnel->email = $request->input('email');
        $personnel->password = bcrypt($request->input('password'));
        $personnel->role = 3; // Role de personnel
        $personnel->save();
    
        return redirect()->route('personnel.create')->with('success', 'Personnel ajouté avec succès');
    }
    public function edit($id)
{
    $personnel = User::findOrFail($id);
    return view('personnel.edit', compact('personnel'));
}
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route('profile.show')->with('status', 'Profile updated successfully');
}


    public function destroy($id)
    {
        $personnel = User::findOrFail($id);
        $personnel->delete();
    
        return redirect()->route('admin.personnel.index')->with('success', 'Personnel supprimé avec succès');
    }
    

}

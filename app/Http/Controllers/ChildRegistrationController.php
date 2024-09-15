<?php
namespace App\Http\Controllers;

use App\Models\ParentModel; 
use App\Models\Enfant;
use App\Models\User;
use App\Models\NiveauScolaire;
use App\Models\Horraire;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChildRegistrationController extends Controller
{
    public function showChildRegistrationForm()
{
    // Récupérer l'année scolaire actuelle
    $currentAnneeScolaire = AnneeScolaire::where('is_current', 1)->first();
    
    return view('inscription.create', [
        'currentAnneeScolaire' => $currentAnneeScolaire,
        'niveauxScolaires' => NiveauScolaire::all(),
        'horraires' => Horraire::all(),
    ]);
}
public function registerChild(Request $request)
{
    // Validation des données du parent
    $validatedParent = $request->validate([
        'parent_name' => 'required|string|max:255',
        'parent_firstname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Crée un parent dans la table users et parents
    $parent = User::create([
        'name' => $validatedParent['parent_name'],
        'prenom' => $validatedParent['parent_firstname'],
        'email' => $validatedParent['email'],
        'pwd' => bcrypt($validatedParent['password']), // Utiliser bcrypt pour hacher le mot de passe
        'etat' => 1, // Ou tout autre logique que vous avez
        'id_role' => 2, // Supposons que 2 est l'ID pour les parents
    ]);

    // Crée les enfants
    foreach ($request->children as $child) {
        Enfant::create([
            'nom' => $child['name'],
            'prenom' => $child['prenom'],
            'date_de_naissance' => $child['date_de_naissance'],
            'id_parent' => $parent->id,
            'niveau_scolaire_id' => $child['niveau_scolaire_id'],
            'horraire_id' => $child['horraire_id'],
            'class' => $child['class'], 
            'id_anneescolaire' => $child['id_anneescolaire'],
        ]);
    }

    return redirect()->back()->with('success', 'Inscription réussie !');
}

}


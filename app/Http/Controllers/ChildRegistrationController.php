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
    public function store(Request $request)
{
    // Validation des champs du formulaire
    $validatedData = $request->validate([
        'parent_name' => 'required|string|max:255',
        'parent_firstname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|string|min:6|confirmed',
        'children.*.name' => 'required|string|max:255',
        'children.*.prenom' => 'required|string|max:255',
        'children.*.date_de_naissance' => 'required|date',
        'children.*.niveau_scolaire_id' => 'required|exists:niveau_scolaires,id',
        'children.*.horraire_id' => 'required|exists:horraires,id',
    ]);

    // Création de l'utilisateur parent dans la table `users`
    $user = new User();
    $user->nom = $request->input('parent_name');
    $user->prenom = $request->input('parent_firstname');
    $user->email = $request->input('email');
    $user->telephone = $request->input('phone');
    $user->pwd = bcrypt($request->input('password')); // Assurez-vous de hacher le mot de passe
    $user->id_role = 2; // Rôle du parent
    $user->etat = 0; // Statut non validé au départ
    $user->save();

    // Création des enfants associés au parent
    foreach ($request->input('children') as $childData) {
        $enfant = new Enfant();
        $enfant->nom = $childData['name'];
        $enfant->prenom = $childData['prenom'];
        $enfant->date_de_naissance = $childData['date_de_naissance'];
        $enfant->niveau_scolaire_id = $childData['niveau_scolaire_id'];
        $enfant->horraire_id = $childData['horraire_id'];
        $enfant->user_id = $user->id; // Associer l'enfant au parent (relation)
        $enfant->save();
    }

    return redirect()->back()->with('success', 'Inscription réussie !');
}

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
    $user = User::create([
        'name' => $validatedParent['parent_name'],
        'prenom' => $validatedParent['parent_firstname'],
        'email' => $validatedParent['email'],
        'telephone' => $request->input('phone'),  // Changez ici en 'phone'
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
            'id_user' => $user->id,
            'niveau_scolaire_id' => $child['niveau_scolaire_id'],
            'horraire_id' => $child['horraire_id'],
            'class' => $child['class'], 
            'id_anneescolaire' => $child['id_anneescolaire'],
        ]);
    }

    return redirect()->back()->with('success', 'Inscription réussie !');
}

}


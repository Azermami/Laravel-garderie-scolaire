<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentModel; // Modèle parent
use App\Models\Enfant; // Modèle enfant
use App\Models\NiveauScolaire;
use App\Models\Horraire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
{
    $niveauxScolaires = NiveauScolaire::all();
    $horraires = Horraire::all();
    return view('inscriptions.create', compact('niveauxScolaires', 'horraires'));
}

    public function store(Request $request)
    {
        // Validation des données du parent
        $validatedParent = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $validatedParent['parent_name'],
            'prenom' => $validatedParent['parent_firstname'],
            'email' => $validatedParent['email'],
            'pwd' => bcrypt($validatedParent['password']),
            'id_role' => 2, // Rôle parent
            'etat' => 0, // Par défaut, non validé
        ]);

        // Création du parent
        $parent = ParentModel::create([
            'nom' => $validatedParent['parent_name'],
            'email' => $validatedParent['email'],
            'telephone' => $validatedParent['phone'],
        ]);

        // Validation et création des enfants
        foreach ($request->children as $child) {
            $validatedChild = Validator::make($child, [
                'name' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'date_de_naissance' => 'required|date',
                'niveau_scolaire_id' => 'required|exists:niveau_scolaires,id',
                'horraire_id' => 'required|exists:horraires,id',
            ])->validate();

            Enfant::create([
                'nom' => $validatedChild['name'],
                'prenom' => $validatedChild['prenom'],
                'date_de_naissance' => $validatedChild['date_de_naissance'],
                'niveau_scolaire_id' => $validatedChild['niveau_scolaire_id'],
                'horraire_id' => $validatedChild['horraire_id'],
                'id_parent' => $parent->id, // Associe l'enfant au parent
            ]);
        }

        return redirect()->route('registere.form')->with('success', 'Inscription réussie !');
    }


    public function showDashboard()
    {
        // Récupérer les niveaux scolaires depuis la base de données
        $niveauxScolaires = NiveauScolaire::all();

        // Récupérer les horaires depuis la base de données
        $horraires = Horraire::all();

        // Retourner la vue avec les données
        return view('front.dashboard', [
            'niveauxScolaires' => $niveauxScolaires,
            'horraires' => $horraires,
        ]);
    }
    public function showRegistrationForm()
    {
        // Récupérer les niveaux scolaires disponibles
        $niveauxScolaires = NiveauScolaire::all();
        // Récupérer les horaires disponibles (si nécessaire)
        $horraires = Horraire::all();
    
        return view('inscription.create', compact('niveauxScolaires', 'horraires'));
    }
    
    /**
     * Enregistre un parent et ses enfants.
     */
    public function registerChild(Request $request)
    {
        // Validation des données du formulaire
        $validator = Validator::make($request->all(), [
            'parent_name' => 'required|string|max:255',
            'parent_firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'children.*.name' => 'required|string|max:255',
            'children.*.date_de_naissance' => 'required|date',
            'children.*.niveau_scolaire_id' => 'required|exists:niveau_scolaires,id',
            'children.*.horraire_id' => 'required|exists:horraires,id',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Création du parent
        $parent = ParentModel::create([
            'nom' => $request->parent_name,
            'prenom' => $request->parent_firstname,
            'email' => $request->email,
            'telephone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
    
        // Enregistrement des enfants
        foreach ($request->children as $child) {
            $parent->enfants()->create([
                'nom' => $child['name'],
                'date_de_naissance' => $child['date_of_birth'],
                'niveau_scolaire_id' => $child['niveau_scolaire_id'],
                'horraire_id' => $child['horraire_id'],
            ]);
        }
    
        return redirect()->route('registere.form')->with('success', 'Inscription réussie!');
    }
}

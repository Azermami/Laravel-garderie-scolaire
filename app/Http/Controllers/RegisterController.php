<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentModel; // Modèle parent
use App\Models\Enfant; // Modèle enfant
use App\Models\NiveauScolaire;
use App\Models\AnneeScolaire;
use App\Models\Horraire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    
    public function index(Request $request)
{
    // Récupérer toutes les années scolaires pour le menu déroulant
    $anneesScolaires = AnneeScolaire::all();

    // Récupérer l'année scolaire sélectionnée à partir de la requête
    $selectedAnneeScolaire = $request->input('annee_scolaire');

    // Filtrer les parents par l'année scolaire sélectionnée
    $query = ParentModel::with('enfants');

    if ($selectedAnneeScolaire) {
        // Filtrer les parents ayant des enfants dans l'année scolaire sélectionnée
        $query->whereHas('enfants', function ($q) use ($selectedAnneeScolaire) {
            $q->where('id_anneescolaire', $selectedAnneeScolaire);
        });
    }

    $parents = $query->paginate(10);

    return view('inscriptions.index', [
        'personnels' => $parents, 
        'anneesScolaires' => $anneesScolaires, 
        'selectedAnneeScolaire' => $selectedAnneeScolaire,
        'etat' => $request->input('etat')
    ]);
}

    public function create()
    {
        $niveauxScolaires = NiveauScolaire::all();
        $horraires = Horraire::all();
    
        // Récupérer l'année scolaire actuelle
        $currentAnneeScolaire = AnneeScolaire::where('is_current', 1)->first();
    
        return view('inscriptions.create', compact('niveauxScolaires', 'horraires', 'currentAnneeScolaire'));
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

    // Création de l'utilisateur parent
    $user = User::create([
        'nom' => $validatedParent['parent_name'],
        'prenom' => $validatedParent['parent_firstname'],
        'email' => $validatedParent['email'],
        'telephone' => $validatedParent['phone'],
        'pwd' => bcrypt($validatedParent['password']),
        'id_role' => 2, // Rôle parent
        'etat' => 0,    // Par défaut, non validé
    ]);

    // Récupérer l'année scolaire actuelle
    $currentAnneeScolaire = AnneeScolaire::where('is_current', 1)->first();

    // Validation et création des enfants
    foreach ($request->children as $child) {
        $validatedChild = Validator::make($child, [
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_de_naissance' => 'required|date',
            'niveau_scolaire_id' => 'required|exists:niveau_scolaires,id',
            'horraire_id' => 'required|exists:horraires,id',
            'annee' => 'required', // Assurez-vous que l'année scolaire est envoyée et valide
        ])->validate();

        Enfant::create([
            'nom' => $validatedChild['name'],
            'prenom' => $validatedChild['prenom'],
            'date_de_naissance' => $validatedChild['date_de_naissance'],
            'niveau_scolaire_id' => $validatedChild['niveau_scolaire_id'], // Enregistrement du niveau scolaire
            'horraire_id' => $validatedChild['horraire_id'], // Enregistrement de l'horaire
            'id_user' => $user->id,
            'id_parent' => $user->id, // ou $parent->id selon votre structure
            'id_anneescolaire' => $currentAnneeScolaire ? $currentAnneeScolaire->id : null, // Enregistrement de l'année scolaire actuelle
            'class' => $validatedChild['annee'], // Enregistrement de la classe (année choisie)
        ]);
    }

    return redirect()->route('inscriptions.index')->with('success', 'Enregistrement effectué avec succès.');
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

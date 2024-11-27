<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentModel;
use App\Models\Enfant;
use App\Models\NiveauScolaire;
use App\Models\Horraire;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer l'état (validé ou non validé) et l'année scolaire sélectionnée
        $etat = $request->input('etat', 0); // Valeur par défaut 0 pour non validés
        $selectedAnneeScolaire = $request->input('annee_scolaire'); // Obtenez l'année scolaire sélectionnée
    
        // Récupérer toutes les années scolaires pour le menu déroulant
        $anneesScolaires = AnneeScolaire::all();
    
        // Initialisation de la requête de base pour récupérer les parents selon leur état (validé ou non)
        $query = User::where('id_role', 2) // Parent role id is 2
                     ->where('etat', $etat); // Filtrer selon l'état validé/non validé
                     if ($request->has('search') && !empty($request->input('search'))) {
                        $search = $request->input('search');
                        $query->where(function ($q) use ($search) {
                            $q->where('nom', 'like', "%$search%")
                              ->orWhere('prenom', 'like', "%$search%");
                        });
                    }
                
        // Filtrer aussi par l'année scolaire sélectionnée si disponible
        if ($selectedAnneeScolaire) {
            $query->whereHas('enfants', function ($q) use ($selectedAnneeScolaire) {
                $q->where('id_anneescolaire', $selectedAnneeScolaire);
            });
        }
    
        // Paginer les résultats
        $personnels = $query->paginate(10);
    
        return view('inscriptions.index', [
            'personnels' => $personnels,
            'etat' => $etat,
            'anneesScolaires' => $anneesScolaires,
            'selectedAnneeScolaire' => $selectedAnneeScolaire
        ]);
    }
    

    
    public function showValidated()
    {
        // Obtenez tous les utilisateurs avec le rôle 2 (parent) et l'état 1 (validé)
        $personnels = User::where('id_role', 2)
            ->where('etat', 1)
            ->paginate(10);  
        
        return view('inscriptions.index', compact('personnels'));
    }

public function getAnnees($niveauScolaireId)
{
    $niveau = NiveauScolaire::findOrFail($niveauScolaireId);
    
    return response()->json([
        'debut_annee' => $niveau->debut_annee,
        'fin_annee' => $niveau->fin_annee,
    ]);
}
    public function validateParent($id)
    {
        $user = User::findOrFail($id);
        $user->etat = 1; // Change l'état à vérifié
        $user->save();

        return redirect()->route('inscriptions.index')->with('success', 'Parent validé avec succès!');
    }


    public function create()
    {
        // Récupérer l'année scolaire courante où is_current = 1
        $currentAnneeScolaire = AnneeScolaire::where('is_current', 1)->first();
    
        // Vérifiez si une année scolaire courante existe
        if (!$currentAnneeScolaire) {
            return redirect()->back()->with('error', 'Aucune année scolaire actuelle n\'a été définie.');
        }
    
        // Récupérer les autres données nécessaires
        $niveauxScolaires = NiveauScolaire::all();
        $horraires = Horraire::all();
    
        // Passer les données à la vue
        return view('inscriptions.create', compact('niveauxScolaires', 'horraires', 'currentAnneeScolaire'));
    }
    
    
    public function store(Request $request)
{
    $request->validate([
        'parent_name' => 'required|string',
        'parent_firstname' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'required|min:6',
        'children.*.name' => 'required|string',
        'children.*.prenom' => 'required|string',
        'children.*.date_de_naissance' => 'required|date',
        'children.*.niveau_scolaire_id' => 'required|exists:niveaux_scolaires,id',
        'children.*.horraire_id' => 'required|exists:horraires,id',
    ]);

    // Enregistrement du parent
    $parent = new User();
    $parent->nom = $request->input('parent_name');
    $parent->prenom = $request->input('parent_firstname');
    $parent->email = $request->input('email');
    $parent->pwd = bcrypt($request->input('password')); // Encrypter le mot de passe
    $parent->telephone = $request->input('phone');
    $parent->id_role = 2; // Assurez-vous que 2 est bien l'ID des parents
    $parent->etat = 0; // Parent non validé par défaut
    $parent->save();

    // Récupérer l'année scolaire courante
    $id_anneescolaire = $request->input('id_anneescolaire');

    // Enregistrement des enfants
    foreach ($request->input('children') as $childData) {
        $enfant = new Enfant();
        $enfant->nom = $childData['name'];
        $enfant->prenom = $childData['prenom'];
        $enfant->date_de_naissance = $childData['date_de_naissance'];
        $enfant->id_parent = $parent->id;
        $enfant->id_anneescolaire = $id_anneescolaire; // Associer à l'année scolaire courante
        $enfant->niveau_scolaire_id = $childData['niveau_scolaire_id'];
        $enfant->horraire_id = $childData['horraire_id'];
        $enfant->save();
    }

    return redirect()->route('inscriptions.index')->with('success', 'Enfants et parent enregistrés avec succès.');
}

    
}


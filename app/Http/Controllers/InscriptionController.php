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
        $etat = $request->input('etat', 0); // Valeur par défaut 0 pour non validés
        $selectedAnneeScolaire = $request->input('annee_scolaire'); // Obtenez l'année scolaire sélectionnée
    
        // Récupérez les parents selon leur état
        $personnels = User::where('id_role', 2)
            ->where('etat', $etat)
            ->paginate(10);
    
        // Récupérer toutes les années scolaires pour le menu déroulant
        $anneesScolaires = AnneeScolaire::all();
    
        // Filtrer les enfants en fonction de l'année scolaire sélectionnée
        $enfants = Enfant::when($selectedAnneeScolaire, function ($query, $selectedAnneeScolaire) {
            return $query->where('id_anneescolaire', $selectedAnneeScolaire);
        })->get();
    
        return view('inscriptions.index', compact('personnels', 'etat', 'anneesScolaires', 'enfants', 'selectedAnneeScolaire'));
    }
    

    
    public function showValidated()
    {
        // Obtenez tous les utilisateurs avec le rôle 2 (parent) et l'état 1 (validé)
        $personnels = User::where('id_role', 2)
            ->where('etat', 1)
            ->paginate(10);  
        
        return view('inscriptions.index', compact('personnels'));
    }
    
    // public function index()
    // {
    //     // Requête pour obtenir les parents non vérifiés avec leur téléphone
    //     $personnels = DB::table('users')
    //         ->join('parent', 'users.id', '=', 'parent.id')
    //         ->where('users.id_role', 2) // Rôle 2 pour les parents
    //         ->where('users.etat', 0) // État 0 pour non vérifiés
    //         ->select('users.id', 'users.nom', 'users.prenom', 'users.email', 'parent.telephone')
            
    //         ->get();
        
    //     // Retourne la vue avec les données
    //     return view('inscriptions.index', compact('personnels'));
    // }

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
        // Vous pouvez commenter cette ligne après avoir testé les données envoyées
        // dd($request->all());
    
        // Valider les données soumises
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
            'id_anneescolaire' => 'required|exists:anneescolaire,id', 
        ]);
        
        $id_anneescolaire = $request->input('id_anneescolaire'); 
        

    
        // Vérifiez si 'children' est un tableau valide
        if ($request->has('children')) {
            // Enregistrer les enfants
            foreach ($request->input('children') as $childData) {
                Enfant::create([
                    'nom' => $childData['name'],
                    'prenom' => $childData['prenom'],
                    'date_de_naissance' => $childData['date_de_naissance'],
                    'niveau_scolaire_id' => $childData['niveau_scolaire_id'],
                    'horraire_id' => $childData['horraire_id'],
                    'id_anneescolaire' => $id_anneescolaire,
                    'id_parent' => $parentId, // Assurez-vous que $parentId est correctement défini
                ]);
            
            
            }
        }
    
        return redirect()->route('success.page')->with('success', 'Enregistrement réussi');
    }


    
}


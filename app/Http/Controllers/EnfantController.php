<?php
namespace App\Http\Controllers;
use App\Models\AnneeScolaire;
use App\Models\Personnel;
use App\Models\Enfant;
use App\Models\ParentModel;
use App\Models\NiveauEnfant;
use App\Models\NiveauScolaire;
use App\Models\Horraire;

use Illuminate\Http\Request;


class EnfantController extends Controller
{
   
    
    // public function index(Request $request)
    // {
    //     // Récupérer toutes les années scolaires
    //     $anneesScolaires = AnneeScolaire::all();
    
    //     // Définir l'année scolaire sélectionnée
    //     $selectedAnneeScolaire = $request->input('annee_scolaire');
    
    //     // Filtrer les personnels en fonction de l'année scolaire si sélectionnée
    //     $user = Personnel::with('enfants')
    //         ->when($selectedAnneeScolaire, function($query, $selectedAnneeScolaire) {
    //             return $query->whereHas('enfants', function($query) use ($selectedAnneeScolaire) {
    //                 $query->where('id_annee_scolaire', $selectedAnneeScolaire);
    //             });
    //         })
    //         ->paginate(10);
    
    //     return view('inscriptions.index', compact('personnels', 'anneesScolaires', 'selectedAnneeScolaire'));
    // }
    public function index(Request $request)
{
    // Récupérer toutes les années scolaires
    $anneesScolaires = AnneeScolaire::all();

    // Définir l'année scolaire sélectionnée
    $selectedAnneeScolaire = $request->input('annee_scolaire');
    
    // Récupérer la valeur du champ de recherche
    $search = $request->input('search');

    // Construire la requête avec les filtres
    $enfants = Enfant::with(['niveauScolaire', 'horraire'])
        ->join('users', 'enfants.id_user', '=', 'users.id')
        ->where('users.etat', 1) // Filtrer par utilisateurs validés
        ->when($selectedAnneeScolaire, function ($query) use ($selectedAnneeScolaire) {
            return $query->where('enfants.id_anneescolaire', $selectedAnneeScolaire);
        })
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('enfants.nom', 'like', '%' . $search . '%')
                      ->orWhere('enfants.prenom', 'like', '%' . $search . '%');
            });
        })
        ->select('enfants.*') // Sélectionner uniquement les colonnes des enfants
        ->paginate(10);

    // Retourner la vue avec les enfants filtrés
    return view('inscriptions.enfants.index', compact('enfants', 'anneesScolaires', 'selectedAnneeScolaire', 'search'));
}

    
    public function redirectEnfantsByAnneeScolaire(Request $request)
    {
        // Récupère l'année scolaire sélectionnée depuis la requête
        $anneeScolaireId = $request->input('annee_scolaire');
    
        // Récupérer les enfants associés à cette année scolaire
        $enfants = Enfant::where('id_annee_scolaire', $anneeScolaireId)->get();
    
        // Rediriger vers la vue des enfants avec la liste des enfants pour l'année scolaire sélectionnée
        return view('enfants.index', compact('enfants'));
    }
    
    
public function showEnfants($id)
{
    $anneescolaire = AnneeScolaire::findOrFail($id);
    $enfants = Enfant::where('idanneescolaire', $id)->get();
    
    return view('anneescolaire.enfants', compact('anneescolaire', 'enfants'));
}


    public function create()
    {
        $niveauxScolaires = NiveauScolaire::all();
        return view('enfants.create', compact('niveauxScolaires'));
    }
    public function show($id)
    {
        // Récupérer l'enfant avec son parent
        $enfant = Enfant::with('parent')->findOrFail($id);

        // Passer les données à la vue
        return view('enfants.show', compact('enfant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_de_naissance' => 'required|date',
            'niveau_scolaire_id' => 'required|exists:niveau_scolaires,id',
            'debut_annee' => 'required|integer|min:1|max:6', // Choisir une année entre 1 et 6
        ]);

        // Enregistrer l'enfant
        $enfant = Enfant::create($request->only('nom', 'prenom', 'date_de_naissance'));

        // Enregistrer l'association dans la table `niveau_enfant`
        NiveauEnfant::create([
            'enfant_id' => $enfant->id,
            'niveau_scolaire_id' => $request->niveau_scolaire_id,
            'debut_annee' => $request->debut_annee,
        ]);

        return redirect()->route('enfants.index')->with('success', 'Enfant ajouté avec succès');
    }
    public function getAnnees($niveauScolaireId)
    {
        // Récupérer les années scolaires associées au niveau scolaire
        $anneesScolaires = AnneeScolaire::whereHas('niveaux', function($query) use ($niveauScolaireId) {
            $query->where('niveau_scolaire_id', $niveauScolaireId);
        })->get();
    
        return response()->json($anneesScolaires);
    }
    
    public function getClasses($niveauScolaireId)
    {
        // Récupérer les classes associées au niveau scolaire
        $classes = NiveauEnfant::where('niveau_scolaire_id', $niveauScolaireId)->get();
    
        return response()->json($classes);
    }
    public function getAnneesByNiveau($niveauId)
{
    $niveau = NiveauScolaire::findOrFail($niveauId);
    return response()->json([
        'debut_annee' => $niveau->debut_annee,
        'fin_annee' => $niveau->fin_annee,
    ]);
}
public function niveauScolaire() {
    return $this->belongsTo(NiveauScolaire::class);
}


public function horraire() {
    return $this->belongsTo(Horraire::class);
}

   
    public function edit($id)
    {
        // Récupérer l'enfant à modifier
        $enfant = Enfant::findOrFail($id);
        
        // Récupérer l'année scolaire en cours
        $anneeScolaireEnCours = AnneeScolaire::where('is_current', 1)->first();
    
        // Récupérer les autres données (niveaux scolaires, horaires, etc.)
        $niveaux = NiveauScolaire::all();
        $horaires = Horraire::all();
    
        // Passer les données à la vue
        return view('inscriptions.edit', compact('enfant', 'niveaux', 'horaires', 'anneeScolaireEnCours'));
    }
    
public function update(Request $request, $id)
{
    // Validation des champs
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'date_de_naissance' => 'required|date',
        'niveau_scolaire_id' => 'required|integer',
        'horraire_id' => 'required|integer',
        'id_anneescolaire' => 'required|integer', // Assurez-vous de valider l'année scolaire en cours
    ]);

    // Récupérer l'enfant à modifier
    $enfant = Enfant::findOrFail($id);

    // Mise à jour des données de l'enfant
    $enfant->nom = $request->input('nom');
    $enfant->prenom = $request->input('prenom');
    $enfant->date_de_naissance = $request->input('date_de_naissance');
    $enfant->niveau_scolaire_id = $request->input('niveau_scolaire_id');
    $enfant->horraire_id = $request->input('horraire_id');
    $enfant->id_anneescolaire = $request->input('id_anneescolaire'); // Mise à jour avec l'année scolaire en cours

    // Sauvegarder les changements
    $enfant->save();

    // Redirection après la mise à jour
    return redirect()->route('enfants.index')->with('success', 'Enfant mis à jour avec succès.');
}


    public function destroy($id)
    {
        $enfant = Enfant::findOrFail($id);
        $enfant->delete();
    
        return redirect()->back()->with('success', 'Enfant supprimé avec succès.');
    }
    
  
}

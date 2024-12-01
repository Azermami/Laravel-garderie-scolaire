<?php

namespace App\Http\Controllers;

use App\Models\NiveauScolaire;
use Illuminate\Http\Request;

class NiveauScolaireController extends Controller
{
    public function getAnneesScolaires($niveauId)
{
    // Assurez-vous d'avoir une relation entre le NiveauScolaire et AnneeScolaire
    $niveau = NiveauScolaire::find($niveauId);

    if ($niveau) {
        $annees = $niveau->anneesScolaires()->get();
        return response()->json($annees);
    }

    return response()->json(['error' => 'Niveau scolaire non trouvé'], 404);
}

public function index()
{
    // Assurez-vous d'utiliser paginate au lieu de get
    $niveaux = NiveauScolaire::paginate(10); // 10 correspond au nombre d'éléments par page
    return view('niveau_scolaire.index', compact('niveaux'));
}


    // Méthode pour afficher la création de niveau scolaire
    public function create()
    {
        return view('niveau_scolaire.create');
    }

    // Méthode pour stocker un nouveau niveau scolaire
//     public function store(Request $request)
// {
//     // Validation des données
//     $request->validate([
//         'niveau_scolaire' => 'required|string|max:255',
//         'debut_annee' => 'required|integer|min:1',
//         'fin_annee' => 'required|integer|gte:debut_annee',
//     ]);

//     // Ajout du niveau scolaire
//     NiveauScolaire::create([
//         'niveau_scolaire' => $request->niveau_scolaire,
//         'debut_annee' => $request->debut_annee,
//         'fin_annee' => $request->fin_annee,
//     ]);

//     // Redirection avec un message de succès
//     return redirect()->route('niveau-scolaire.index')->with('success', 'Niveau scolaire ajouté avec succès');
// }

public function store(Request $request)
{
    $request->validate([
        'niveau_scolaire' => 'required|string|max:255',
        'debut_annee' => 'required|integer|min:1',
        'fin_annee' => 'required|integer|gte:debut_annee',
        'prix_niveau' => 'required|numeric|min:0',
    ]);

    NiveauScolaire::create($request->all());

    return redirect()->route('niveau-scolaire.index')->with('success', 'Niveau scolaire ajouté avec succès');
}




   public function edit($id)
{
    $niveau = NiveauScolaire::findOrFail($id);
    return view('niveau_scolaire.edit', compact('niveau'));
}

   
    
public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'niveau_scolaire' => 'required|string|max:255',
        'debut_annee' => 'required|integer|min:1',
        'fin_annee' => 'required|integer|gte:debut_annee',
        'prix_niveau' => 'required|numeric|min:0',
    ]);

    // Récupération du niveau à modifier
    $niveau = NiveauScolaire::findOrFail($id);

    // Mise à jour du niveau avec toutes les données nécessaires
    $niveau->update($request->only('niveau_scolaire', 'debut_annee', 'fin_annee','prix_niveau'));

    // Redirection après succès
    return redirect()->route('niveau-scolaire.index')->with('success', 'Niveau scolaire mis à jour avec succès');
}


    public function destroy($id)
    {
        $niveau = NiveauScolaire::findOrFail($id);
        $niveau->delete();

        return redirect()->route('niveau-scolaire.index')->with('success', 'Niveau scolaire supprimé avec succès');
    }
}

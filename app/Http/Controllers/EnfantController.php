<?php
namespace App\Http\Controllers;

use App\Models\Enfant;
use App\Models\NiveauEnfant;
use App\Models\NiveauScolaire;
use Illuminate\Http\Request;

class EnfantController extends Controller
{
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
    public function destroy($id)
    {
        $enfant = Enfant::findOrFail($id);
        $enfant->delete();
    
        return redirect()->back()->with('success', 'Enfant supprimé avec succès.');
    }
    
  
}

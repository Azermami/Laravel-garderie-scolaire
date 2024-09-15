<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class AnneeScolaireController extends Controller
{
    public function index()
    {
        $anneesScolaires = AnneeScolaire::all();
        return view('annéescolaire.index', compact('anneesScolaires'));
    }

    public function create()
    {
        return view('annéescolaire.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'anneescolaire' => 'required|string|unique:anneescolaire,anneescolaire',
        ]);

        AnneeScolaire::create([
            'anneescolaire' => $request->anneescolaire,
        ]);

        return redirect()->route('anneescolaire.index')->with('success', 'Année scolaire ajoutée avec succès');
    }

    public function edit($id)
    {
        $anneeScolaire = AnneeScolaire::findOrFail($id);
        return view('annéescolaire.edit', compact('anneeScolaire'));  // Changez 'annéescolaire' par 'anneescolaire'
    }
    
    
    public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'anneescolaire' => 'required|string|max:255|unique:anneescolaire,anneescolaire,' . $id,
    ]);

    // Récupérer l'année scolaire
    $anneeScolaire = AnneeScolaire::findOrFail($id);

    // Mise à jour des champs
    $anneeScolaire->update([
        'anneescolaire' => $request->anneescolaire,
    ]);

    // Redirection avec un message de succès
    return redirect()->route('anneescolaire.index')->with('success', 'Année scolaire mise à jour avec succès');
}

public function setCurrentYear($id)
{
    // Réinitialiser toutes les années scolaires pour ne pas être la période actuelle
    AnneeScolaire::query()->update(['is_current' => false]);

    // Définir l'année scolaire actuelle
    $currentYear = AnneeScolaire::findOrFail($id);
    $currentYear->is_current = true;
    $currentYear->save();

    return redirect()->route('anneescolaire.index')->with('success', 'Année scolaire actuelle mise à jour.');
}


    public function destroy($id)
    {
        $annee = AnneeScolaire::findOrFail($id);
        $annee->delete();

        return redirect()->route('anneescolaire.index')->with('success', 'Année scolaire supprimée avec succès');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NiveauEnfant;

class NiveauEnfantController extends Controller
{
    /**
     * Récupérer les classes (niveau_enfants) associées à un niveau scolaire spécifique.
     *
     * @param  int  $niveauId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClasses($niveauId)
    {
        // Récupérer les classes associées à ce niveau scolaire
        $classes = NiveauEnfant::where('niveau_scolaire_id', $niveauId)->get();

        // Retourner les résultats sous forme de JSON pour la requête AJAX
        return response()->json($classes);
    }

    /**
     * Afficher la liste des classes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer toutes les classes pour l'affichage dans la vue
        $niveauEnfants = NiveauEnfant::all();
        return view('niveau_enfants.index', compact('niveauEnfants'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle classe (niveau_enfant).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Afficher la vue pour créer une nouvelle classe
        return view('niveau_enfants.create');
    }

    /**
     * Enregistrer une nouvelle classe (niveau_enfant) dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'niveau_scolaire_id' => 'required|exists:niveaux_scolaires,id',
            'nom' => 'required|string|max:255',
        ]);

        // Créer une nouvelle classe (niveau_enfant)
        NiveauEnfant::create($request->all());

        // Rediriger avec un message de succès
        return redirect()->route('niveau_enfants.index')->with('success', 'Classe ajoutée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'une classe existante.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Récupérer la classe à éditer
        $niveauEnfant = NiveauEnfant::findOrFail($id);

        // Afficher la vue d'édition
        return view('niveau_enfants.edit', compact('niveauEnfant'));
    }

    /**
     * Mettre à jour une classe existante dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'niveau_scolaire_id' => 'required|exists:niveaux_scolaires,id',
            'nom' => 'required|string|max:255',
        ]);

        // Récupérer la classe à mettre à jour
        $niveauEnfant = NiveauEnfant::findOrFail($id);

        // Mettre à jour les données
        $niveauEnfant->update($request->all());

        // Rediriger avec un message de succès
        return redirect()->route('niveau_enfants.index')->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Supprimer une classe existante.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Récupérer la classe à supprimer
        $niveauEnfant = NiveauEnfant::findOrFail($id);

        // Supprimer la classe
        $niveauEnfant->delete();

        // Rediriger avec un message de succès
        return redirect()->route('niveau_enfants.index')->with('success', 'Classe supprimée avec succès.');
    }
}

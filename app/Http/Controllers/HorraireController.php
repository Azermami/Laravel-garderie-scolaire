<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horraire;

class HorraireController extends Controller
{
    /**
     * Affiche la liste des horaires.
     */
    public function index()
    {
        $horraires = Horraire::all(); // Récupère tous les horaires
        return view('horraire.index', compact('horraires')); // Retourne la vue avec les horaires
    }

    /**
     * Affiche le formulaire pour créer un nouvel horaire.
     */
    public function create()
    {
        return view('horraire.create'); // Retourne la vue pour créer un horaire
    }

    /**
     * Stocke un nouvel horaire dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'horraire' => 'required|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        Horraire::create($request->all());

        return redirect()->route('horraire.index')->with('success', 'Horaire ajouté avec succès.');
    }

    /**
     * Affiche le formulaire pour modifier un horaire existant.
     */
    public function edit(Horraire $horraire)
    {
        return view('horraire.edit', compact('horraire')); // Retourne la vue pour modifier un horaire
    }

    /**
     * Met à jour un horaire existant dans la base de données.
     */
    public function update(Request $request, Horraire $horraire)
{
    // Testez avec une valeur en dur pour start_time
    $request->merge(['start_time' => '14:30']); // Exemple de valeur correcte

    $request->validate([
        'horraire' => 'required|string|max:255',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
    ]);

    $horraire->update($request->all());

    return redirect()->route('horraire.index')->with('success', 'Horaire modifié avec succès.');
}

    

    /**
     * Supprime un horaire existant de la base de données.
     */
    public function destroy(Horraire $horraire)
    {
        $horraire->delete();

        return redirect()->route('horraire.index')->with('success', 'Horaire supprimé avec succès.');
    }
}

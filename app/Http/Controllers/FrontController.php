<?php

namespace App\Http\Controllers;

use App\Models\NiveauScolaire;
use App\Models\Horraire;

class FrontController extends Controller
{
    public function showDashboard()
    {
        // Fetch data for niveaux scolaires and horaires
        $niveauxScolaires = NiveauScolaire::all();
        $horraires = Horraire::all();

        // Return the view with the data
        return view('front.dashboard', [
            'niveauxScolaires' => $niveauxScolaires,
            'horraires' => $horraires,
        ]);
    }
}

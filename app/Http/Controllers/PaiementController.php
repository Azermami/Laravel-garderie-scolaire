<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Paiement;
use App\Models\Enfant;
use App\Models\NiveauScolaire;
use App\Models\Horraire;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    // Méthode pour afficher le formulaire d'ajout de paiement
    public function create()
    {
        // Récupérer les enfants dont les parents sont validés
        $enfants = Enfant::join('users', 'enfants.id_user', '=', 'users.id')
            ->where('users.etat', 1)
            ->select('enfants.*')
            ->get();

        return view('paiements.create', compact('enfants'));
    }

    // Méthode pour calculer le montant basé sur le niveau scolaire et l'horaire
    public function getMontant(Request $request)
    {
        // Récupérer l'enfant sélectionné
        $enfant = Enfant::with('niveauScolaire', 'horraire')->find($request->enfant_id);
        
        // Calculer le montant total
        if ($enfant) {
            $montant = ($enfant->niveauScolaire ? $enfant->niveauScolaire->prix_niveau : 0)
                     + ($enfant->horraire ? $enfant->horraire->prix_horraire : 0);
            return response()->json(['montant' => $montant]);
        }

        return response()->json(['montant' => 0], 404);
    }

    // Méthode pour enregistrer le paiement dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'enfant_id' => 'required|exists:enfants,id',
            'mode_paiement' => 'required|string',
            'status' => 'required|string',
        ]);
    
        // Récupérer l'enfant
        $enfant = Enfant::find($request->enfant_id);
    
        // Calculer le montant total dû (niveau scolaire + horaire)
        $montant_total_du = ($enfant->niveauScolaire ? $enfant->niveauScolaire->prix_niveau : 0) +
                            ($enfant->horraire ? $enfant->horraire->prix_horraire : 0);
    
        // Si le mode de paiement n'est pas "tranche", payer tout le montant directement
        if ($request->mode_paiement !== 'tranche') {
            // Vérifier si le paiement est déjà complet
            $montant_total_paye = $enfant->paiements()->sum('montant');
    
            if ($montant_total_paye >= $montant_total_du) {
                return redirect()->route('paiements.index')->with('error', 'Le paiement pour cet enfant est déjà complet.');
            }
    
            // Créer un paiement avec le montant total dû
            Paiement::create([
                'id_user' => $enfant->id_user,
                'id_enfant' => $enfant->id,
                'montant' => $montant_total_du - $montant_total_paye,  // Enregistrer le montant restant
                'mode_paiement' => $request->mode_paiement,
                'status' => 'complet',  // Le statut doit être "complet" pour ces méthodes
                'date_paiement' => now(),
            ]);
    
            return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
        }
    
        // Gestion des paiements en tranche
        $request->validate([
            'montant_paye' => 'required|numeric|min:1',
        ]);
    
        $montant_total_paye = $enfant->paiements()->sum('montant');
        $montant_restant = $montant_total_du - $montant_total_paye;
    
        // Vérifier si le montant de la tranche dépasse le montant restant
        if ($request->montant_paye > $montant_restant) {
            return redirect()->back()->with('error', 'Le montant de la tranche ne peut pas dépasser le montant restant de ' . $montant_restant . ' €.');
        }
    
        // Créer le paiement de la tranche
        Paiement::create([
            'id_user' => $enfant->id_user,
            'id_enfant' => $enfant->id,
            'montant' => $request->montant_paye,  // Enregistrer la tranche
            'mode_paiement' => $request->mode_paiement,
            'status' => $request->status,
            'date_paiement' => now(),
        ]);
    
        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }
    
    

    


    // Méthode pour afficher la liste des paiements
    public function index(Request $request)
    {
        // Récupération du terme de recherche
        $search = $request->input('search');
    
        // Requête pour filtrer les enfants par nom ou prénom et récupérer leurs paiements
        $paiements = Paiement::with('enfant.niveauScolaire', 'enfant.horraire')
            ->whereHas('enfant.user', function ($query) {
                // Vérification que le parent est validé (etat = 1)
                $query->where('etat', 1);
            })
            ->when($search, function ($query, $search) {
                // Recherche par nom ou prénom de l'enfant
                return $query->whereHas('enfant', function ($query) use ($search) {
                    $query->where('nom', 'like', '%' . $search . '%')
                        ->orWhere('prenom', 'like', '%' . $search . '%');
                });
            })
            ->get();
    
        // Retourne la vue avec les paiements filtrés
        return view('paiements.index', compact('paiements'));
    }

    public function destroy($id)
{
    $paiement = Paiement::findOrFail($id);
    $paiement->delete();

    return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
}
public function show($id)
{
    $paiement = Paiement::with('enfant.niveauScolaire', 'enfant.horraire')->findOrFail($id);

    // Calcul du montant total (niveau scolaire + horaire)
    $montant_total = ($paiement->enfant->niveauScolaire ? $paiement->enfant->niveauScolaire->prix_niveau : 0) +
                     ($paiement->enfant->horraire ? $paiement->enfant->horraire->prix_horraire : 0);

    // Calcul du montant restant
    $montant_restant = $montant_total - $paiement->montant;

    return view('paiements.show', compact('paiement', 'montant_total', 'montant_restant'));
}
public function recu($id)
{
    // Récupérer le paiement avec les informations nécessaires
    $paiement = Paiement::with('enfant.niveauScolaire', 'enfant.horraire')->findOrFail($id);

    // Calculer le montant total et le montant restant
    $montant_total = ($paiement->enfant->niveauScolaire ? $paiement->enfant->niveauScolaire->prix_niveau : 0) +
                     ($paiement->enfant->horraire ? $paiement->enfant->horraire->prix_horraire : 0);
    $montant_restant = $montant_total - $paiement->montant;

    // Générer le PDF avec les détails du paiement
    $pdf = PDF::loadView('paiements.recu', compact('paiement', 'montant_total', 'montant_restant'));

    // Télécharger le fichier PDF
    return $pdf->download('recu_paiement_' . $paiement->id . '.pdf');
}

}

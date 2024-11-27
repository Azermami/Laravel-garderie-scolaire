<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentModel;
use App\Models\Personnel;
use App\Models\Enfant;
use App\Models\NiveauScolaire;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $adminCount = User::where('id_role', 1)->count();
        $verifiedParentsCount = User::where('id_role', 2)->where('etat', 1)->count();
        $pendingParentsCount = User::where('id_role', 2)->where('etat', 0)->count();
        $personnelCount = User::where('id_role', 3)->count();
        
        // Ajout des statistiques sur les enfants et niveaux scolaires
        $niveaux = NiveauScolaire::withCount('enfants')->get(); // Assurez-vous d'avoir une relation 'enfants' sur le modèle NiveauScolaire
        $totalEnfants = Enfant::count(); // Compter tous les enfants
    
        return view('dashboard', compact('adminCount', 'verifiedParentsCount', 'pendingParentsCount', 'personnelCount', 'niveaux', 'totalEnfants'));
    }
    
//parent stat 

// Example in your ParentController or the relevant controller
public function showDashboard()
{
    // Fetch payments data (modify according to your payment model/logic)
    $payments = Payment::where('parent_id', auth()->user()->id)  // Example query
                        ->orderBy('created_at', 'desc')
                        ->take(5)  // For example, taking the latest 5 payments
                        ->get();

    return view('parent.dashboard', compact('payments'));  // Pass payments to the view
}

    
}

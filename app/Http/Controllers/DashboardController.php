<?php
namespace App\Http\Controllers;

use App\Models\User; // Assurez-vous d'inclure les bons modèles
use App\Models\ParentModel; // Assurez-vous d'inclure les bons modèles
use App\Models\Personnel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $adminCount = User::where('id_role', 1)->count();
        $verifiedParentsCount = User::where('id_role', 2)->where('etat', 1)->count();
        $pendingParentsCount = User::where('id_role', 2)->where('etat', 0)->count();
        $personnelCount = User::where('id_role', 3)->count();
    
        return view('dashboard', compact('adminCount', 'verifiedParentsCount', 'pendingParentsCount', 'personnelCount'));
    }
    
}

<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentModel;

class ParentController extends Controller
{
    public function dashboard()
    {
        return view('parent.dashboard');
    }


   
    public function showPending()
{
      $parents = ParentModel::all();
    $parents = ParentModel::whereHas('user', function($query) {
        $query->where('etat', 0);
    })->with('enfants')->get();

    return view('inscriptions.index', compact('parents'));
}



public function validateParent($id)
    {
        // Utilisez le modèle ParentModel pour trouver le parent
        $parent = ParentModel::find($id);
        if ($parent) {
            // Trouver l'utilisateur associé au parent
            $user = $parent->user;
            if ($user) {
                $user->etat = 1; // Changer l'état de l'utilisateur à 1
                $user->save();
                return redirect()->route('parents.pending')->with('success', 'Parent validé avec succès');
            } else {
                return redirect()->route('parents.pending')->with('error', 'Utilisateur associé non trouvé');
            }
        }
        return redirect()->route('parents.pending')->with('error', 'Parent non trouvé');
    }

}
<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentModel;
use App\Models\User; // Import the User model at the top if not already imported

class ParentController extends Controller
{
    public function index()
    {
        // Fetch the logged-in parent's children
        $children = Enfant::where('parent_id', auth()->user()->id)->get();

        // Pass the children to the view
        return view('parent.dashboard', compact('children'));
    }
    public function dashboard()
    {
        return view('parent.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('parent.profile');
    }
    
    public function children()
    {
        // Your logic to fetch and display children's information
        return view('parent.children'); // Ensure you have the Blade file `children.blade.php` in the `resources/views/parent/` directory
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
    public function suivie()
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Check if the user is a parent (id_role = 2)
        if ($user->id_role == 2 && $user->etat == 1) {
            // Fetch the children associated with this parent
            $enfants = $user->enfants;
    
            return view('parent.suivie', compact('enfants'));
        }
    
        // Redirect or show an error if the user is not a validated parent
        return redirect()->back()->with('error', 'Unauthorized access');
    }
    

    public function suiviePaiements()
{
    // Get the authenticated user (parent)
    $user = auth()->user();

    // Check if the user is a parent
    if ($user->id_role == 2 && $user->etat == 1) {
        // Fetch the payments related to this parent
        $paiements = $user->paiements()->with('enfant')->get();

        return view('parent.suivie-paiements', compact('paiements'));
    }

    // Redirect if the user is not authorized
    return redirect()->back()->with('error', 'Unauthorized access');
}



public function profileUpdate(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        'telephone' => 'required|string|max:20',
    ]);

    $user = Auth::user(); // Récupère l'utilisateur connecté
    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->email = $request->email;
    $user->telephone = $request->telephone;
    $user->save();

    return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès');
}



}
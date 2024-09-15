<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChildRegistrationController;
use App\Http\Controllers\ParentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\NiveauScolaireController;
use App\Http\Controllers\HorraireController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\EnfantController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route accessible à tous les utilisateurs
Route::get('/front', function () {
    return view('front.dashboard');
})->name('front');

// Routes accessibles uniquement pour les utilisateurs non authentifiés (guest)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    
// Route accessible à tous les utilisateurs
Route::get('/front', [FrontController::class, 'showDashboard'])->name('front');


   // Route::post('/register-child', [ChildRegistrationController::class, 'register'])->name('register.child');
    Route::post('/register-child', [ChildRegistrationController::class, 'registerChild'])->name('register.child');


    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);
    
    Route::get('/admin/login', [SessionsController::class, 'createAdmin'])->name('admin.login');
    Route::post('/admin/login', [SessionsController::class, 'storeAdmin']);

    Route::get('/forgot-password', [ResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetController::class, 'sendEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

// Routes accessibles uniquement pour les utilisateurs authentifiés (auth)
Route::middleware('auth')->group(function () {
    // Dashbord des parents
    Route::middleware(['parent', 'validated'])->group(function () {
        Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    });

    // Dashbored du personnel
    Route::middleware(['personnel', 'validated'])->group(function () {
        Route::get('/personnel/dashboard', [PersonnelController::class, 'dashboard'])->name('personnel.dashboard');
    });

    // Dashbord l'admin
    Route::middleware(['admin', 'validated'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
    });

    Route::get('/personnel/create', [PersonnelController::class, 'create'])->name('personnel.create');
    Route::post('/personnel', [PersonnelController::class, 'store'])->name('personnel.store');
    
    Route::get('/admin/add-personnel', [AdminController::class, 'createPersonnel'])->name('admin.createPersonnel');
    Route::post('/admin/add-personnel', [AdminController::class, 'storePersonnel'])->name('admin.addPersonnel');
    
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('inscriptions.index');
//gestion des année scolaire 
Route::post('/anneescolaire/set-current/{id}', [AnneeScolaireController::class, 'setCurrentYear'])->name('anneescolaire.setCurrentYear');

Route::get('/anneescolaire', [AnneeScolaireController::class, 'index'])->name('anneescolaire.index');
Route::get('/anneescolaire/create', [AnneeScolaireController::class, 'create'])->name('anneescolaire.create');
Route::post('/anneescolaire', [AnneeScolaireController::class, 'store'])->name('anneescolaire.store');
Route::get('/anneescolaire/{id}/edit', [AnneeScolaireController::class, 'edit'])->name('anneescolaire.edit');
//Route::put('/anneescolaire/{id}', [AnneeScolaireController::class, 'update'])->name('anneescolaire.update');
Route::delete('/anneescolaire/{id}', [AnneeScolaireController::class, 'destroy'])->name('anneescolaire.destroy');

Route::get('/api/niveaux/{id}/annees', [InscriptionController::class, 'getAnnees']);

 //gestion des niveaux scolaire 
 Route::resource('niveau-scolaire', NiveauScolaireController::class);

 //gestion  des horaire
 Route::resource('horraire', HorraireController::class);

 //Route::get('/admin/parents-pending', [ParentController::class, 'showPending'])->name('parents.pending');
 Route::post('/admin/validate-parent/{id}', [ParentController::class, 'validateParent'])->name('parents.validate');
 Route::get('/parents-pending', [ParentController::class, 'showPending'])->name('parents.pending');

 Route::resource('anneescolaire', AnneeScolaireController::class);

Route::resource('horraire', HorraireController::class);

 Route::get('/register', [RegisterController::class, 'create'])->name('register');

 Route::post('/register-child', [RegisterController::class, 'store'])->name('register.child');

Route::get('/registere', [RegisterController::class, 'create'])->name('registere.form');

// // Route pour traiter les données soumises
 Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


 // Route pour afficher le formulaire d'inscription des parents
Route::get('inscriptions', [InscriptionController::class, 'index'])->name('inscriptions.index');
Route::get('inscriptions/create', [InscriptionController::class, 'create'])->name('inscriptions.create');
Route::post('inscriptions', [InscriptionController::class, 'store'])->name('inscriptions.store');
Route::get('inscriptions/{id}/edit', [InscriptionController::class, 'edit'])->name('inscriptions.edit');
Route::put('inscriptions/{id}', [InscriptionController::class, 'update'])->name('inscriptions.update');
Route::post('inscriptions/{id}/validate', [InscriptionController::class, 'validate'])->name('inscriptions.validate');
Route::post('/inscriptions/validate/{id}', [InscriptionController::class, 'validateParent'])->name('inscriptions.validate');
Route::get('/inscriptions/valides', [InscriptionController::class, 'showValidated'])->name('inscriptions.valides');

//gestion des inscription 
// Routes pour la gestion des inscriptions
Route::get('/inscription/create', [InscriptionController::class, 'create'])->name('inscription.create');
Route::post('/inscription/store', [InscriptionController::class, 'store'])->name('inscription.store');
Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('inscriptions.index');


Route::get('/get-classes/{niveauId}', [NiveauEnfantController::class, 'getClasses']);
Route::resource('niveau_enfants', NiveauEnfantController::class);


//gestion des personnel 
// Personnel routes pour le croud
Route::prefix('admin')->group(function () {
    Route::get('/personnel', [PersonnelController::class, 'index'])->name('admin.personnel.index');
    Route::get('/personnel/create', [PersonnelController::class, 'create'])->name('admin.personnel.create');
    Route::post('/personnel/store', [PersonnelController::class, 'store'])->name('admin.personnel.store');
    Route::get('/personnel/{id}/edit', [PersonnelController::class, 'edit'])->name('admin.personnel.edit');
    Route::put('/personnel/{id}', [PersonnelController::class, 'update'])->name('admin.personnel.update');
    Route::delete('/personnel/{id}', [PersonnelController::class, 'destroy'])->name('admin.personnel.destroy');
});




// Autres routes...

// Route pour afficher le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');
});

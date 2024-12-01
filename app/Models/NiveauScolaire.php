<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveauScolaire extends Model
{
    use HasFactory;

     protected $table = 'niveau_scolaires';
    //protected $fillable = ['niveau_scolaire'];
    //protected $fillable = ['niveau_scolaire', 'debut_annee', 'fin_annee'];
    protected $fillable = ['niveau_scolaire', 'debut_annee', 'fin_annee', 'prix_niveau'];


    public function getAnnees()
{
    return range($this->debut_annee, $this->fin_annee);
}
public function store(Request $request)
{
    $request->validate([
        'niveau_scolaire' => 'required|string|max:255',
    ]);

    $debut_annee = $request->debut_annee;
    $fin_annee = $request->fin_annee;

    if ($request->niveau_scolaire === 'Primaire') {
        $debut_annee = 1;
        $fin_annee = 6;
    } elseif ($request->niveau_scolaire === 'Secondaire') {
        $debut_annee = 7;
        $fin_annee = 9;
    }

    NiveauScolaire::create([
        'niveau_scolaire' => $request->niveau_scolaire,
        'debut_annee' => $debut_annee,
        'fin_annee' => $fin_annee,
    ]);

    return redirect()->route('niveau-scolaire.index')->with('success', 'Niveau scolaire ajouté avec succès');
}
// public function enfants()
// {
//     return $this->hasManyThrough(Enfant::class, NiveauEnfant::class, 'niveau_scolaire_id', 'id', 'id', 'enfant_id');
// }

public function enfants()
    {
        return $this->hasMany(Enfant::class, 'niveau_scolaire_id');
    }
}


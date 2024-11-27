<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;

    protected $table = 'enfants';

    protected $fillable = ['nom', 'prenom', 'date_de_naissance', 'niveau_scolaire_id', 'horraire_id', 'id_user','id_parent', 'id_anneescolaire','class'];
    
// public function parent()
// {
//     return $this->belongsTo(ParentModel::class, 'id_parent');
// }

public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}


public function niveauScolaire()
{
    return $this->belongsTo(NiveauScolaire::class, 'niveau_scolaire_id');
}
    public function horraire()
    {
        return $this->belongsTo(Horraire::class, 'horraire_id');
    }

    public function anneeScolaire() 
    {
        return $this->belongsTo(AnneeScolaire::class, 'id_anneescolaire');
    }
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_enfant');
    }
    
    public function niveaux()
{
    return $this->hasMany(NiveauEnfant::class);
}

}

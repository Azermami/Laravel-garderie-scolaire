<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveauEnfant extends Model
{
    use HasFactory;

    protected $fillable = [
        'niveau_scolaire_id',
        'debut_annee',
        'fin_annee',
        'nom',
    ];

    public function niveauScolaire()
    {
        return $this->belongsTo(NiveauScolaire::class, 'niveau_scolaire_id');
    }
    
    public function niveauEnfant()
    {
        return $this->hasOne(NiveauEnfant::class);
    }
   
}

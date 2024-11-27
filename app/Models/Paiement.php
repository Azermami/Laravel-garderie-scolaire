<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    // Les champs autorisés à être remplis via des formulaires
    protected $fillable = [
        'id_enfant', 'id_user', 'montant', 'date_paiement', 'status', 'mode_paiement'
    ];

    // Relation avec l'utilisateur (parent)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation avec l'enfant
    public function enfant()
    {
        return $this->belongsTo(Enfant::class, 'id_enfant');
    }
}

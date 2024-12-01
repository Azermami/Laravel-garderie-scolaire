<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom', 'prenom', 'email','telephone', 'pwd', 'id_role', 'etat'
    ];
    
    protected $hidden = [
        'pwd', 'remember_token',
        'etat' => 'boolean',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->pwd;
    }

    public function isAdmin()
    {
        return $this->id_role == 1; 
    }

    public function isParent()
    {
        return $this->id_role == 2;
    }

    public function isValidated()
    {
        return $this->etat == 1;
    }

    public function isPersonnel()
    {
        return $this->id_role == 3; 
    }


public function enfants()
{
    return $this->hasMany(Enfant::class, 'id_user');
}


public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_user'); 
    }

    // public function parent()
    // {
    //     return $this->hasOne(Parent::class);
    // }


    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

}

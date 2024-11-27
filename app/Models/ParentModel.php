<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parent'; // Specify table name if it's not following Laravel's naming convention

    protected $fillable = [
        'id','nom', 'email', 'telephone'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
public function enfants()
{
    return $this->hasMany(Enfant::class, 'id_user');
}

    
}

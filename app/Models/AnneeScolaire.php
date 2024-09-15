<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    protected $table = 'anneescolaire';
    
    protected $fillable = [
        'anneescolaire',
        'is_current',
    ];

}

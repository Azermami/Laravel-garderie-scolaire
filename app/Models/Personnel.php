<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    public function enfants()
    {
        return $this->hasManyThrough(Enfant::class, Parent::class, 'id_personnel', 'id_parent');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horraire extends Model
{
    use HasFactory;
    protected $table = 'horraires';
   // protected $fillable = ['horraire', 'start_time', 'end_time'];
    protected $fillable = ['horraire', 'start_time', 'end_time', 'prix_horraire'];

}

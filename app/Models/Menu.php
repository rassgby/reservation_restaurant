<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nom_plat',
        'prix',
        'description',
        'jour',
        'categorie'
    ];
}

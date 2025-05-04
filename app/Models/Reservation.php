<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'date',
        'heure',
        'nombre_personnes',
        'status',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}

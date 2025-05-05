<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'heure',
        'nombre_personnes',
        'special_requests',
        'user_id',    // Si vous avez un système d'authentification
        'status',     // Pour gérer les statuts (confirmé, annulé, etc.)
        'email',      // Si vous souhaitez envoyer des confirmations par email
        'phone',      // Si vous souhaitez envoyer des confirmations par SMS
        'name',       // Nom du client
    ];

    // Relation avec l'utilisateur (si applicable)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
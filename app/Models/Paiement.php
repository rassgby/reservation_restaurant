<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'montant',
        'date',
        'status',
        'methode',
        'reservation_id'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}

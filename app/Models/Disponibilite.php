<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Disponibilite extends Model
{
    protected $fillable = [
        'date',
        'heure',
        'capacite_totale',
        'places_reservees',
        'disponible'
    ];

    // Méthode pour vérifier si des places sont disponibles
    public function placesDisponibles()
    {
        return $this->disponible && ($this->capacite_totale - $this->places_reservees > 0);
    }

    // Méthode pour calculer le nombre de places restantes
    public function placesRestantes()
    {
        return $this->capacite_totale - $this->places_reservees;
    }
}

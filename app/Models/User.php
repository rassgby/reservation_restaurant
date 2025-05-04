<?php

// App\Models\User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'password',
        'mot_de_passe',
        'type',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function isClient()
    {
        return $this->type === 'client';
    }

    public function isGerant()
    {
        return $this->type === 'gerant';
    }

    public function isAdmin()
    {
        return $this->type === 'administrateur';
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}

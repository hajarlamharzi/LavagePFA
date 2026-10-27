<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'mot_de_passe',
        'role'
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // IMPORTANT: Spécifier le champ mot de passe personnalisé
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function getAuthIdentifierName()
    {
        return 'nom';
    }

    public function getAuthIdentifier()
    {
        return $this->nom;
    }
}
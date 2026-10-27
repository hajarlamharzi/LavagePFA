<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'type_vehicule',
        'date_reservation',
        'heure_reservation',
        'type_lavage',
        'remarque'
    ];
}

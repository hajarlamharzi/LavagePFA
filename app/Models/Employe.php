<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'cin',
        'telephone',
        'remarque',
    ];

    public function prestations()
    {
        return $this->hasMany(Prestation::class);
    }
    public function avances()
{
    return $this->hasMany(\App\Models\Avance::class);
}
public function presences()
{
    return $this->hasMany(\App\Models\Presence::class);
}


}

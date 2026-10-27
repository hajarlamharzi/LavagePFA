<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'type_vehicule',
        'type_lavage',
        'prix',
        'matricule',
        'marque',
        'employe_id',
        'date_prestation',
        'remarque',
        'societe_id',
        'statut_paiement',

    ];


    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }
    public function vehicule()
{
    return $this->belongsTo(Vehicule::class);
}
public function typeLavage()
{
    return $this->belongsTo(TypeLavage::class);
}



}

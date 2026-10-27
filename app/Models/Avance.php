<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
    protected $fillable = ['employe_id', 'date', 'montant', 'remarque'];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}

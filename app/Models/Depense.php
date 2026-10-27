<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'autre_type',
        'montant',
        'date',
        'remarque',
    ];

    /**
     * Retourne le type réel de la dépense (standard ou autre).
     */
    public function getTypeCompletAttribute()
    {
        return $this->type === 'autre' && $this->autre_type
            ? $this->autre_type
            : $this->type;
    }
}

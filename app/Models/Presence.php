<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = ['employe_id', 'date', 'etat', 'remarque', 'heure_entree'];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}

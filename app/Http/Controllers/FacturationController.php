<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestation;
use App\Models\Societe;

class FacturationController extends Controller
{
    /**
     * Affiche le formulaire de sélection de société et dates
     */
    public function index()
    {
        $societes = Societe::all();
        return view('facturation.index', compact('societes'));
    }

    /**
     * Affiche le résultat de la recherche de prestations
     */
    public function resultat(Request $request)
    {
        $request->validate([
            'societe_id' => 'required|exists:societes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $prestations = Prestation::where('societe_id', $request->societe_id)
            ->where('type_vehicule', 'voiture_de_service')
            ->whereBetween('date_prestation', [$request->date_debut, $request->date_fin])
            ->orderBy('date_prestation')
            ->get();

        $total = $prestations->sum('prix');

        $societe = Societe::findOrFail($request->societe_id);

        return view('facturation.resultat', compact('prestations', 'total', 'societe', 'request'));
    }
}

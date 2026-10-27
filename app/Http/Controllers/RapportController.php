<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestation;
use App\Models\Depense;
use App\Models\Avance;

class RapportController extends Controller
{
    public function calcul(Request $request)
    {
        $debut = $request->date_debut ?? date('Y-m-d');
        $fin   = $request->date_fin ?? date('Y-m-d');

        // Exclure voiture_de_service du calcul
        $totalLavages = Prestation::whereBetween('date_prestation', [$debut, $fin])
            ->where('type_vehicule', '!=', 'voiture_de_service')
            ->sum('prix');

        $totalDepenses = Depense::whereBetween('date', [$debut, $fin])->sum('montant');
        $totalAvances = Avance::whereBetween('date', [$debut, $fin])->sum('montant');

        $solde = $totalLavages - ($totalDepenses + $totalAvances);

        return view('rapport.calcul', [
            'totaux' => [
                'lavages'  => $totalLavages,
                'depenses' => $totalDepenses,
                'avances'  => $totalAvances,
                'solde'    => $solde,
            ],
            'debut' => $debut,
            'fin'   => $fin,
        ]);
    }

    public function details(Request $request)
    {
        $request->validate([
            'type' => 'required|in:lavages,depenses,avances',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $type = $request->type;
        $debut = $request->date_debut;
        $fin = $request->date_fin;

        $data = collect();

        switch ($type) {
            case 'lavages':
                // On laisse TOUT afficher, y compris les voiture_de_service
                $data = Prestation::with('employe')
                    ->whereBetween('date_prestation', [$debut, $fin])
                    ->get();
                break;
            case 'depenses':
                $data = Depense::whereBetween('date', [$debut, $fin])->get();
                break;
            case 'avances':
                $data = Avance::with('employe')
                    ->whereBetween('date', [$debut, $fin])
                    ->get();
                break;
        }
// Sauvegarde la sélection dans la session
session([
    'rapport_type' => $type,
    'rapport_date_debut' => $debut,
    'rapport_date_fin' => $fin,
]);

return view('rapport.details', compact('data', 'type', 'debut', 'fin'));

    }
}

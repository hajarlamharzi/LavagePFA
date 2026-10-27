<?php

namespace App\Http\Controllers;

use App\Models\Avance;
use App\Models\Employe;
use Illuminate\Http\Request;

class AvanceController extends Controller
{
    public function index()
    {
        $avances = Avance::with('employe')->orderByDesc('date')->get();
        return view('avances.index', compact('avances'));
    }

    public function create()
    {
        $employes = Employe::all();
        return view('avances.create', compact('employes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date' => 'required|date',
            'montant' => 'required|numeric|min:0',
            'remarque' => 'nullable|string',
        ]);

        Avance::create($request->all());

        return redirect()->route('avances.index')->with('success', 'Avance enregistrée avec succès.');
    }

    public function edit($id)
    {
        $avance = Avance::findOrFail($id);
        $employes = Employe::all();
        return view('avances.edit', compact('avance', 'employes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date' => 'required|date',
            'montant' => 'required|numeric|min:0',
            'remarque' => 'nullable|string',
        ]);

        $avance = Avance::findOrFail($id);
        $avance->update($request->all());

        return redirect()->route('avances.index')->with('success', 'Avance mise à jour avec succès.');
    }

    public function calcul(Request $request)
    {
        $avances = collect();
        $total = 0;
        $totauxParEmploye = collect();

        if ($request->isMethod('post')) {
            $request->validate([
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
            ]);

            $debut = $request->date_debut;
            $fin = $request->date_fin;

            // Récupérer les avances entre les deux dates
            $avances = Avance::with('employe')
                        ->whereBetween('date', [$debut, $fin])
                        ->get();

            // Total général
            $total = $avances->sum('montant');

            // Totaux par employé
            $totauxParEmploye = $avances
                ->groupBy('employe_id')
                ->map(function ($items) {
                    return [
                        'employe' => $items->first()->employe,
                        'total' => $items->sum('montant'),
                    ];
                });
        }

        return view('avances.calcul', compact('avances', 'total', 'request', 'totauxParEmploye'));
    }


}

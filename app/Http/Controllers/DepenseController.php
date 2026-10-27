<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class DepenseController extends Controller
{
    public function index()
    {
        $depenses = Depense::orderByDesc('date')->get();
        return view('depenses.index', compact('depenses'));
    }

    public function create()
    {
        $types = ['Électricité', 'Eau', 'Produits de lavage', 'Entretien matériel', 'Salaires', 'autre'];
        return view('depenses.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'autre_type' => 'nullable|string|max:100',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'remarque' => 'nullable|string|max:255',
        ]);

        Depense::create($validated);

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée avec succès.');
    }

    public function edit($id)
    {
        $depense = Depense::findOrFail($id);
        $types = ['Électricité', 'Eau', 'Produits de lavage', 'Entretien matériel', 'Salaires', 'autre'];
        return view('depenses.edit', compact('depense', 'types'));
    }

    public function update(Request $request, $id)
    {
        $depense = Depense::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string',
            'autre_type' => 'nullable|string|max:100',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'remarque' => 'nullable|string|max:255',
        ]);

        $depense->update($validated);

        return redirect()->route('depenses.index')->with('success', 'Dépense mise à jour avec succès.');
    }

    public function calcul(Request $request)
    {
        $depenses = collect();
        $total = 0;
        $parMois = collect();
        $titre = '';

        if ($request->isMethod('post')) {
            $mode = $request->input('mode');

            if ($mode === 'intervalle') {
                $request->validate([
                    'date_debut' => 'required|date',
                    'date_fin' => 'required|date|after_or_equal:date_debut',
                ]);

                $debut = $request->date_debut;
                $fin = $request->date_fin;

                $depenses = Depense::whereBetween('date', [$debut, $fin])->get();
                $total = $depenses->sum('montant');
                $titre = "Dépenses du $debut au $fin";

                // Groupement par mois dans l'intervalle
                $parMois = Depense::select(
                    DB::raw("DATE_TRUNC('month', date) AS mois"),
                    DB::raw("SUM(montant) AS total_mois")
                )
                ->whereBetween('date', [$debut, $fin])
                ->groupBy(DB::raw("DATE_TRUNC('month', date)"))
                ->orderBy('mois')
                ->get();
            }

            if ($mode === 'mois') {
                $request->validate([
                    'mois_selectionne' => 'required|date_format:Y-m',
                ]);

                $mois = $request->mois_selectionne;
                $debut = $mois . '-01';
                $fin = date('Y-m-t', strtotime($debut));

                $depenses = Depense::whereBetween('date', [$debut, $fin])->get();
                $total = $depenses->sum('montant');
                $titre = "Dépenses pour " . \Carbon\Carbon::parse($debut)->translatedFormat('F Y');
            }
        }

        return view('depenses.calcul', compact('depenses', 'total', 'parMois', 'titre', 'request'));
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::orderBy('type_vehicule')->get();
        return view('tarifs.index', compact('tarifs'));
    }

    public function create()
    {
        return view('tarifs.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_vehicule' => 'required|string|max:255',
            'type_lavage' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
        ]);

        Tarif::create($validated);

        return redirect()->route('tarifs.index')->with('success', 'Tarif ajouté avec succès.');
    }

    public function edit(Tarif $tarif)
    {
        return view('tarifs.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $validated = $request->validate([
            'type_vehicule' => 'required|string|max:255',
            'type_lavage' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
        ]);

        $tarif->update($validated);

        return redirect()->route('tarifs.index')->with('success', 'Tarif mis à jour avec succès.');
    }

    public function destroy(Tarif $tarif)
    {
        $tarif->delete();
        return redirect()->route('tarifs.index')->with('success', 'Tarif supprimé.');
    }
   
}

<?php

namespace App\Http\Controllers;

use App\Models\Societe;
use Illuminate\Http\Request;

class SocieteController extends Controller
{
    // tes méthodes

    /**
     * Afficher la liste des sociétés.
     */
    public function index()
    {
        $societes = Societe::orderBy('nom')->paginate(10);
        return view('societes.index', compact('societes'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('societes.create');
    }

    /**
     * Enregistrer une nouvelle société.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:50',
        ]);

        Societe::create($validated);

        return redirect()->route('societes.index')
                         ->with('success', 'Société ajoutée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(Societe $societe)
    {
        return view('societes.edit', compact('societe'));
    }

    /**
     * Mettre à jour une société existante.
     */
    public function update(Request $request, Societe $societe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:50',
        ]);

        $societe->update($validated);

        return redirect()->route('societes.index')
                         ->with('success', 'Société mise à jour avec succès.');
    }

    /**
     * Supprimer une société.
     */
    public function destroy(Societe $societe)
    {
        $societe->delete();

        return redirect()->route('societes.index')
                         ->with('success', 'Société supprimée avec succès.');
    }
}

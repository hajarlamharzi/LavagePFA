<?php

namespace App\Http\Controllers;
 use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Employe;
class PresenceController extends Controller
{
    // 1. Empêcher les doublons : contrôle dans PresenceController@store



    public function store(Request $request)
    {
        // Vérifier si une présence existe déjà pour cet employé à cette date
        $exists = Presence::where('employe_id', $request->employe_id)
                          ->where('date', $request->date)
                          ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Présence déjà enregistrée pour cet employé à cette date.');
        }

        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date' => 'required|date',
            'etat' => 'required|in:présent,absent',
            'heure_entree' => 'required',
            'remarque' => 'nullable|string',
        ]);

        Presence::create($request->all());

return view('presences.index', [
    'presences' => $presences,
    'totalPresent' => $totalPresent,
    'presenceParEmploye' => $presenceParEmploye,
    'employes' => $employes,
    'success' => session()->pull('success'),
    'error' => session()->pull('error')
]);
    }

// 2. Ajout de l'édition (edit/update)

public function edit($id)
{
    $presence = Presence::findOrFail($id);
    $employes = Employe::all();
    return view('presences.edit', compact('presence', 'employes'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'employe_id' => 'required|exists:employes,id',
        'date' => 'required|date',
        'heure_entree' => 'required',
        'etat' => 'required|in:présent,absent',
        'remarque' => 'nullable|string',
    ]);

    $presence = Presence::findOrFail($id);

    // Empêcher les doublons sauf pour l'enregistrement actuel
    $exists = Presence::where('employe_id', $request->employe_id)
        ->where('date', $request->date)
        ->where('id', '!=', $id)
        ->exists();

    if ($exists) {
        return back()->withErrors(['duplicate' => 'Cet employé a déjà une présence enregistrée pour cette date.'])->withInput();
    }

    $presence->update($request->all());

    return redirect()->route('presences.index')->with('success', 'Présence mise à jour avec succès.');
}

// 3. Filtre sur index

public function index(Request $request)
{
    // Initialisation de la requête avec le modèle Presence
    $query = Presence::with('employe')->orderByDesc('date');

    // Appliquer les filtres si présents
    if ($request->filled('start') && $request->filled('end')) {
        $query->whereBetween('date', [$request->start, $request->end]);
    }

    if ($request->filled('employe_id')) {
        $query->where('employe_id', $request->employe_id);
    }

    // Paginer les résultats filtrés
    $presences = $query->paginate(10);

    // Total général des présences "présent"
    $totalPresent = Presence::where('etat', 'présent')
        ->when($request->filled('start') && $request->filled('end'), function ($q) use ($request) {
            $q->whereBetween('date', [$request->start, $request->end]);
        })
        ->count();

    // Total par employé pour la période sélectionnée
    $presenceParEmploye = Presence::with('employe')
        ->selectRaw('employe_id, COUNT(*) as total')
        ->where('etat', 'présent')
        ->when($request->filled('start') && $request->filled('end'), function ($q) use ($request) {
            $q->whereBetween('date', [$request->start, $request->end]);
        })
        ->groupBy('employe_id')
        ->get();

    // Liste des employés pour les filtres ou formulaire
    $employes = Employe::all();

    return view('presences.index', compact('presences', 'totalPresent', 'presenceParEmploye', 'employes'));
}


}

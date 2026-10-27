<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;
use App\Models\Societe;
use App\Models\Prestation;
use App\Models\Employe;
use PDF;
use Illuminate\Support\Facades\DB;

class PrestationController extends Controller
{
    public function genererTicket($id)
    {
        $prestation = Prestation::with(['employe', 'societe'])->findOrFail($id);
        return view('prestations.ticket', compact('prestation'));
    }

    // 1️⃣ Choix du véhicule
    public function selectVehicule()
    {
        $types = [
            ['nom' => 'moto', 'image' => 'moto.png'],
            ['nom' => 'petite_voiture', 'image' => 'petite_voiture.png'],
            ['nom' => 'suv', 'image' => 'suv.png'],
            ['nom' => 'van', 'image' => 'van.png'],
            ['nom' => 'berline', 'image' => 'berline.png'],
            ['nom' => 'voiture_de_service', 'image' => 'v_service.png'],
            ['nom' => 'voiture_utilitaire', 'image' => 'utilitaire.png'],
        ];

        return view('vehicules.select', compact('types'));
    }

    // 2️⃣ Choix du lavage
    public function selectLavage(Request $request)
    {
        $typeVehicule = $request->type_vehicule;

        if (!$typeVehicule) {
            return redirect()->route('vehicules.select')
                ->with('error', 'Type de véhicule manquant.');
        }

        $lavages = Tarif::whereRaw('LOWER(type_vehicule) = ?', [strtolower($typeVehicule)])
            ->when(strtolower($typeVehicule) !== 'moto', function ($query) {
                $query->where('type_lavage', '!=', 'moto');
            })
            ->orderBy('type_lavage')
            ->get();

        return view('lavages.select', compact('typeVehicule', 'lavages'));
    }

    // 3️⃣ Formulaire de création
    public function create(Request $request)
    {
        $typeVehicule = $request->input('type_vehicule');
        $ids = array_filter(explode(',', $request->input('lavages', '')));

        if (!$typeVehicule || empty($ids)) {
            return redirect()->route('vehicules.select')
                ->with('error', 'Veuillez d\'abord choisir un ou plusieurs lavages.');
        }

        $lavagesChoisis = Tarif::whereIn('id', $ids)->get();

        if ($lavagesChoisis->isEmpty()) {
            return redirect()->route('vehicules.select')
                ->with('error', 'Aucun lavage valide sélectionné.');
        }

        $prixTotal = $lavagesChoisis->sum('prix');

        $employes = Employe::all();
        $societes = Societe::all();

        return view('prestations.create', compact(
            'typeVehicule',
            'lavagesChoisis',
            'prixTotal',
            'employes',
            'societes'
        ));
    }

    // 4️⃣ Enregistrement en base
public function store(Request $request)
{
    $validated = $request->validate([
        'type_vehicule' => 'required|string',
        'type_lavage' => 'required|array',
        'type_lavage.*' => 'required|string',
        'prix' => 'required|array',
        'prix.*' => 'required|numeric',
        'matricule' => 'required|string',
        'marque' => 'required|string',
        'employe_id' => 'required|exists:employes,id',
        'remarque' => 'nullable|string',
        'is_societe' => 'nullable',
        'societe_id' => 'nullable|exists:societes,id',
    ]);

    // 1️⃣ On récupère la date actuelle
    $date = now()->toDateString();

    // 2️⃣ On compte le nombre déjà existant dans le mois
    $compteur = Prestation::whereYear('date_prestation', now()->year)
        ->whereMonth('date_prestation', now()->month)
        ->count();

    // 3️⃣ Premier numéro = dernier compteur + 1
    $numeroCourant = $compteur + 1;

    // 4️⃣ Sauvegarder chaque ligne
    for ($i = 0; $i < count($validated['type_lavage']); $i++) {
        Prestation::create([
            'type_vehicule'    => $validated['type_vehicule'],
            'type_lavage'      => $validated['type_lavage'][$i],
            'prix'             => $validated['prix'][$i],
            'matricule'        => $request->matricule,
            'marque'           => $request->marque,
            'employe_id'       => $request->employe_id,
            'remarque'         => $request->remarque,
            'societe_id'       => $request->is_societe ? $request->societe_id : null,
            'statut_paiement'  => $validated['type_vehicule'] === 'voiture_de_service' ? 'non payé' : 'payé',
            'date_prestation'  => $date,
            'numero'           => $numeroCourant
        ]);

        // Incrémente pour le suivant
        $numeroCourant++;
    }

    // 5️⃣ Enregistrement global pour le ticket (liste des lavages)
    $allLavages = [];
    foreach ($validated['type_lavage'] as $index => $type) {
        $allLavages[] = [
            'type_lavage' => $type,
            'prix'        => $validated['prix'][$index],
        ];
    }

    $prestation = Prestation::create([
        'type_vehicule'   => $validated['type_vehicule'],
        'type_lavage'     => json_encode($allLavages),
        'prix'            => array_sum($validated['prix']),
        'matricule'       => $request->matricule,
        'marque'          => $request->marque,
        'employe_id'      => $request->employe_id,
        'remarque'        => $request->remarque,
        'societe_id'      => $request->is_societe ? $request->societe_id : null,
        'statut_paiement' => $validated['type_vehicule'] === 'voiture_de_service' ? 'non payé' : 'payé',
        'date_prestation' => $date,
        'numero'          => $numeroCourant // dernier numéro utilisé
    ]);

    return response()->json([
        'success' => true,
        'id' => $prestation->id
    ]);
    if (count($validated['type_lavage']) === 1) {
    $allLavages = $validated['type_lavage'][0];
} else {
    $allLavages = json_encode(array_map(function ($i) use ($validated) {
        return [
            'type_lavage' => $validated['type_lavage'][$i],
            'prix' => $validated['prix'][$i]
        ];
    }, array_keys($validated['type_lavage'])));
}

}


    // 5️⃣ Liste des prestations
    public function index(Request $request)
    {
        $query = Prestation::with(['employe', 'societe']);

        if ($request->filled('marque')) {
            $query->where('marque', 'LIKE', '%' . $request->marque . '%');
        }

        if ($request->filled('matricule')) {
            $query->where('matricule', 'LIKE', '%' . $request->matricule . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('date_prestation', $request->date);
        }

        if ($request->filled('statut_paiement')) {
            $query->where('statut_paiement', $request->statut_paiement);
        }

        $prestations = $query->orderByDesc('date_prestation')->paginate(10);

        return view('prestations.index', compact('prestations'));
    }
}

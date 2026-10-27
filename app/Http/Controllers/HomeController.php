<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestation;
use App\Models\Depense;
use App\Models\Avance;
use App\Models\Employe;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ✅ Totaux du jour
        $lavagesDuJour = Prestation::whereDate('created_at', $today)
            ->where('type_vehicule', '!=', 'voiture_de_service')
            ->sum('prix');

        $depensesDuJour = Depense::whereDate('created_at', $today)->sum('montant');
        $avancesDuJour = Avance::whereDate('created_at', $today)->sum('montant');

        $solde = $lavagesDuJour - ($depensesDuJour + $avancesDuJour);

        // ✅ Employés actifs aujourd'hui
        $employesActifs = Employe::whereHas('prestations', function ($query) use ($today) {
            $query->whereDate('date_prestation', $today)
                  ->whereNotNull('employe_id');
        })->get();

        // ✅ Dernières prestations
        $recentPrestations = Prestation::orderByDesc('date_prestation')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // ✅ Analyse des lavages du mois
        $debutMois = Carbon::now()->startOfMonth()->toDateString();
        $finMois = Carbon::now()->endOfMonth()->toDateString();

        $prestationsMois = Prestation::whereBetween('date_prestation', [$debutMois, $finMois])->get();

        $lavageCounts = [];

        foreach ($prestationsMois as $prestation) {
            $lavages = json_decode($prestation->type_lavage, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($lavages)) {
                foreach ($lavages as $lavage) {
                    $lavageCounts[$lavage['type_lavage']] = ($lavageCounts[$lavage['type_lavage']] ?? 0) + 1;
                }
            } else {
                $lavageCounts[$prestation->type_lavage] = ($lavageCounts[$prestation->type_lavage] ?? 0) + 1;
            }
        }

        $bestLavage = null;
        if (!empty($lavageCounts)) {
            $bestLavage = collect($lavageCounts)->sortDesc()->take(1)->all();
        }

        // ✅ Prestations du jour avec heure
        $prestationsParHeure = Prestation::selectRaw('EXTRACT(HOUR FROM created_at) as heure, COUNT(*) as total')
            ->whereDate('created_at', $today)
            ->groupBy('heure')
            ->orderBy('heure')
            ->get();

        $heures = $prestationsParHeure->pluck('heure')->toArray();
        $totauxParHeure = $prestationsParHeure->pluck('total')->toArray();

        // ✅ Notifications pour l'utilisateur connecté
        $notifications = auth()->check() ? auth()->user()->unreadNotifications : collect();

        return view('home', [
            'lavagesDuJour' => $lavagesDuJour,
            'depensesDuJour' => $depensesDuJour,
            'avancesDuJour' => $avancesDuJour,
            'solde' => $solde,
            'employesActifs' => $employesActifs,
            'recentPrestations' => $recentPrestations,
            'lavageCounts' => $lavageCounts ?? [],
            'bestLavage' => $bestLavage ?? [],
            'totauxParHeure' => $totauxParHeure,
            'heures' => $heures,
            'notifications' => $notifications,
        ]);
    }
}

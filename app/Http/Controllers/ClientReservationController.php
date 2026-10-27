<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\NewReservationNotification;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppService;

class ClientReservationController extends Controller
{
    /**
     * Affiche le formulaire de réservation pour le client.
     */
    public function create()
    {
        return view('client.reservation');
    }

    /**
     * Enregistre la réservation en base.
     */
   public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'type_vehicule' => 'required|string',
        'services' => 'required|array',
        'services.*' => 'required|string',
        'date_reservation' => 'required|date|after_or_equal:today',
        'heure_reservation' => 'required',
    ]);

    // Vérifier disponibilité
    $existe = Reservation::where('date_reservation', $request->date_reservation)
                         ->where('heure_reservation', $request->heure_reservation)
                         ->exists();
    if ($existe) {
        return back()->withErrors([
            'heure_reservation' => 'Cette heure est déjà réservée. Veuillez choisir une autre.'
        ]);
    }

    // Créer la réservation
    $reservation = Reservation::create([
        'nom' => $request->nom,
        'telephone' => $request->telephone,
        'type_vehicule' => $request->type_vehicule,
        'services' => $request->services,
        'date_reservation' => $request->date_reservation,
        'heure_reservation' => $request->heure_reservation,
        'remarque' => $request->remarque,
    ]);

    // ✅ Format international
    if (str_starts_with($reservation->telephone, '+')) {
        $internationalPhone = $reservation->telephone;
    } else {
        $cleanPhone = ltrim($reservation->telephone, '0');
        $internationalPhone = '+212' . $cleanPhone;
    }

    // ✅ Envoi WhatsApp
    $result = \App\Services\WhatsAppService::send(
        $internationalPhone,
        "✅ Bonjour {$reservation->nom} ! Votre réservation Green Car Wash est confirmée pour le {$reservation->date_reservation} à {$reservation->heure_reservation}. Merci pour votre confiance !"
    );

    \Log::info("Résultat envoi WhatsApp : " . json_encode($result));

    // ✅ Notifier admins et employés
    $admins = User::whereIn('role', ['admin', 'employe'])->get();
    foreach ($admins as $user) {
        $user->notify(new \App\Notifications\NewReservationNotification($reservation));
    }

    return redirect()->route('reservation.form')
        ->with('success', '✅ Votre réservation a été enregistrée avec succès ! Vous recevrez une confirmation sur WhatsApp.');
}

}

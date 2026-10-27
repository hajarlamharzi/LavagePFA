<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
   public function index()
    {
        return view('client.home');
    }
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

    // ✅ Notifier tous les admins et caissiers
    $users = User::whereIn('role', ['admin', 'caissier'])->get();

    foreach ($users as $user) {
        $user->notify(new ReservationCreated($reservation));
    }

    return redirect()->route('reservation.form')
        ->with('success', 'Votre réservation a été enregistrée avec succès !');
}

}

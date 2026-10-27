<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation; // Vérifier cet import

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'type_vehicule' => 'required|string|max:100',
            'date_reservation' => 'required|date|after_or_equal:today',
            'heure_reservation' => 'required',
            'type_lavage' => 'required|string|max:100',
            'remarque' => 'nullable|string',
        ]);

        $reservation = Reservation::create($validated);

        Mail::to($reservation->email)->send(new ReservationConfirmation($reservation));

        return redirect()
            ->route('reservations.create')
            ->with('success', '✅ Votre réservation a été enregistrée avec succès !');
    }

    public function index(Request $request)
    {
        $query = Reservation::query()->orderByDesc('date_reservation')->orderByDesc('heure_reservation');

        if ($request->filled('date_reservation')) {
            $query->whereDate('date_reservation', $request->date_reservation);
        }

        if ($request->filled('type_lavage')) {
            $query->where('type_lavage', $request->type_lavage);
        }

        $reservations = $query->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }
}

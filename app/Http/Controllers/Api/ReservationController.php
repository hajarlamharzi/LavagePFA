<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Mail\ReservationConfirmation; // Vérifier que cet import existe
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['store']);
    }

    // Liste des réservations API
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

        return response()->json($reservations);
    }

    // Création d'une réservation
    public function store(Request $request)
    {
       try {
        Log::info('DEBUG POST DATA:', $request->all());

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'type_vehicule' => 'required|string|max:100',
            'date_reservation' => 'required|date|after_or_equal:today',
            'heure_reservation' => 'required',
            'type_lavage' => 'required|string|max:255',
            'remarque' => 'nullable|string',
        ]);

        // Créer réservation
        $reservation = Reservation::create($validated);
        Log::info('Réservation créée avec succès:', $reservation->toArray());

        // Envoyer email de confirmation
        if(!empty($reservation->email)){
            Log::info('Tentative d\'envoi d\'email à:', ['email' => $reservation->email]);
            
            // Testez d'abord si la classe email existe
            if (class_exists(\App\Mail\ReservationConfirmation::class)) {
                Log::info('Classe ReservationConfirmation trouvée');
                Mail::to($reservation->email)->send(new ReservationConfirmation($reservation));
                Log::info('Email envoyé avec succès');
            } else {
                Log::error('Classe ReservationConfirmation non trouvée');
                throw new \Exception('Classe ReservationConfirmation non trouvée');
            }
        }

        return response()->json([
            'message' => '✅ Votre réservation a été enregistrée avec succès !',
            'reservation' => $reservation
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Erreur de validation:', ['errors' => $e->errors()]);
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Erreur réservation:', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'message' => 'Erreur lors de l\'enregistrement de la réservation',
            'error' => $e->getMessage(),
            'debug' => env('APP_DEBUG') ? [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ] : null
        ], 500);
    }
}   
}
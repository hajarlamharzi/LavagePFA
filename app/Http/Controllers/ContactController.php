<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact; // ← Importez le modèle Contact

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Données invalides'
            ], 422);
        }

        // Enregistrer les données dans la base de données
        try {
            $contact = Contact::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'message' => $request->message
            ]);

            return response()->json([
                'message' => 'Message envoyé avec succès et enregistré en base de données!',
                'data' => $contact // Optionnel: retourner les données enregistrées
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'enregistrement en base de données',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
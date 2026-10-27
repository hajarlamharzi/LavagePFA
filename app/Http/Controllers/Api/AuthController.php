<?php

// app/Http/Controllers/API/AuthController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:users,nom',
            'password' => 'required|string|confirmed|min:4',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'mot_de_passe' => Hash::make($request->password),
            'role' => 'employe',
        ]);

        return response()->json(['message' => 'Utilisateur créé'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('nom', $request->nom)->first();

        if (!$user || !Hash::check($request->password, $user->mot_de_passe)) {
            throw ValidationException::withMessages([
                'nom' => ['Les identifiants sont incorrects.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté']);
    }
}

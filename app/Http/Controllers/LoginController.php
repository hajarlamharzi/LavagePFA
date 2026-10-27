<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Debug: Vérifiez ce qui est reçu
        \Log::info('Login attempt:', $request->all());
        
        // Validation basique
        $request->validate([
            'nom' => 'required',
            'mot_de_passe' => 'required',
        ]);

        // Recherche de l'utilisateur
        $user = User::where('nom', $request->nom)->first();

        if (!$user) {
            \Log::info('User not found: ' . $request->nom);
            return back()->withErrors(['nom' => 'Utilisateur non trouvé'])->withInput();
        }

        // Vérification du mot de passe
        if (Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
            \Log::info('Login successful for user: ' . $user->nom);
            
            // Connexion MANUELLE
            Auth::login($user, $request->has('remember'));
            
            // Régénération de la session
            $request->session()->regenerate();
            
            return redirect()->intended('/home');
        }

        \Log::info('Password incorrect for user: ' . $user->nom);
        return back()->withErrors(['nom' => 'Mot de passe incorrect'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
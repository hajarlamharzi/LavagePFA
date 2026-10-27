<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));
        return view('profile', compact('user'));
    }

    public function edit(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));
        return view('profile_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));

        if (!$user) {
            return redirect()->route('login.form')->withErrors(['error' => 'Vous devez être connecté.']);
        }

        $validated = $request->validate([
            'nom' => 'required',
            'mot_de_passe' => 'nullable|min:4',
        ]);

        $user->nom = $validated['nom'];

        if (!empty($validated['mot_de_passe'])) {
            $user->mot_de_passe = Hash::make($validated['mot_de_passe']);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès !');
    }
}

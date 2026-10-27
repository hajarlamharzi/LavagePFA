<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('nom', $request->nom)->first();

        if ($user && Hash::check($request->password, $user->mot_de_passe)) {
            Session::put('user_id', $user->id);
            Session::put('user_role', $user->role);
            Session::put('user_nom', $user->nom);
            return redirect()->route('home');
        }

        return back()->withErrors([
            'nom' => 'Nom ou mot de passe invalide.',
        ]);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }

    public function home()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $userRole = session('user_role');

        // Simple stats
        $lavagesDuJour = 0;
        $depensesDuJour = 0;
        $avancesDuJour = 0;
        $solde = 0;
        $employesActifs = collect();
        $recentPrestations = collect();

        if ($userRole === 'admin' || $userRole === 'employe') {
            $lavagesDuJour = DB::table('prestations')->whereDate('created_at', today())->sum('montant') ?? 0;
            $depensesDuJour = DB::table('depenses')->whereDate('created_at', today())->sum('montant') ?? 0;
        }

        if ($userRole === 'admin') {
            $avancesDuJour = DB::table('avances')->whereDate('created_at', today())->sum('montant') ?? 0;
            $solde = $lavagesDuJour - ($depensesDuJour + $avancesDuJour);

            $employesActifs = DB::table('presences')
                ->whereDate('date', today())
                ->join('employes', 'presences.employe_id', '=', 'employes.id')
                ->select('employes.prenom', 'employes.nom')
                ->get();

            $recentPrestations = DB::table('prestations')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('home', compact(
            'userRole',
            'lavagesDuJour',
            'depensesDuJour',
            'avancesDuJour',
            'solde',
            'employesActifs',
            'recentPrestations'
        ));
    }
}

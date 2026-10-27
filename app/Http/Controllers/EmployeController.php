<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employe::query();

        if ($search = $request->input('search')) {
            $query->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
        }

        $employes = $query->orderBy('nom')->paginate(10);

        return view('employes.index', compact('employes'));
    }

    public function create()
    {
        return view('employes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'cin' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'remarque' => 'nullable|string',
        ]);

        Employe::create($validated);

        return redirect()->route('employes.index')->with('success', 'Employé ajouté avec succès.');
    }

    public function edit($id)
    {
        $employe = Employe::findOrFail($id);
        return view('employes.edit', compact('employe'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'remarque' => 'nullable|string',
        ]);

        $employe = Employe::findOrFail($id);
        $employe->update($request->all());

        return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès.');
    }


   

    public function destroy(Employe $employe)
    {
        $employe->delete();
        return redirect()->route('employes.index')->with('success', 'Employé supprimé avec succès.');
    }
}

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Liste des Avances</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{-- 🔘 Bouton Ajouter --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('avances.calcul') }}" class="btn btn-info">📊 Calculer les Avances</a>

        <a href="{{ route('avances.create') }}" class="btn btn-success">+ Ajouter une Avance</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Employé</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Remarque</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($avances as $avance)
                <tr>
                    <td>{{ $avance->employe->prenom }} {{ $avance->employe->nom }}</td>
                    <td>{{ $avance->date }}</td> {{-- ✅ corrigé ici --}}
                    <td>{{ number_format($avance->montant, 2) }} DH</td>
                    <td>{{ $avance->remarque }}</td>
                    <td>
                        <a href="{{ route('avances.edit', $avance->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucune avance trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

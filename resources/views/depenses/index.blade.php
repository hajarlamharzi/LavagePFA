@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Liste des Dépenses</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('depenses.create') }}" class="btn btn-primary">+ Ajouter une Dépense</a>
        <a href="{{ route('depenses.calcul') }}" class="btn btn-success ms-2">📊 Calculer Dépenses</a>
    </div>


    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Type</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Remarque</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($depenses as $dep)
                <tr>
                    <td>{{ $dep->type }}</td>
                    <td>{{ number_format($dep->montant, 2) }} DH</td>
                    <td>{{ $dep->date }}</td>
                    <td>{{ $dep->remarque }}</td>
                    <td>
                        <a href="{{ route('depenses.edit', $dep->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucune dépense enregistrée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

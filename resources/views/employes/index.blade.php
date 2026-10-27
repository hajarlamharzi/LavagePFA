@extends('layouts.app')

@section('title', 'Liste des employés')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Liste des Employés</h2>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('employes.index') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou prénom" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </div>
        <div class="col-md-3">
            <a href="{{ route('employes.create') }}" class="btn btn-success w-100">Ajouter un employé</a>
        </div>
    </form>

    {{-- Tableau des employés --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>CIN</th>
                <th>Téléphone</th>
                <th>Remarque</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employes as $emp)
                <tr>
                    <td class="text-center">{{ $emp->id }}</td>
                    <td>{{ $emp->nom }}</td>
                    <td>{{ $emp->prenom }}</td>
                    <td>{{ $emp->cin ?? '-' }}</td>
                    <td>{{ $emp->telephone ?? '-' }}</td>
                    <td>{{ $emp->remarque ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('employes.edit', $emp->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('employes.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet employé ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Aucun employé trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $employes->appends(request()->query())->links() }}
    </div>
</div>
@endsection

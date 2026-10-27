@extends('layouts.app')

@section('title', 'Liste des Sociétés')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-building me-2"></i> Liste des Sociétés
    </h2>

    <a href="{{ route('societes.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle me-1"></i> Ajouter une Société
    </a>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($societes->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($societes as $societe)
                        <tr>
                            <td>{{ $societe->id }}</td>
                            <td>{{ $societe->nom }}</td>
                            <td>{{ $societe->adresse ?? '-' }}</td>
                            <td>{{ $societe->telephone ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('societes.edit', $societe) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>

                                <form action="{{ route('societes.destroy', $societe) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $societes->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            Aucune société enregistrée.
        </div>
    @endif
</div>
@endsection

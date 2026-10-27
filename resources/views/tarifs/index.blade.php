@extends('layouts.app')

@section('title', 'Tarifs des Lavages')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-cash-coin me-2"></i> Tarifs des Lavages
    </h2>

    <a href="{{ route('tarifs.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle me-1"></i> Ajouter un Tarif
    </a>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($tarifs->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Type Véhicule</th>
                        <th>Type Lavage</th>
                        <th>Prix (MAD)</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifs as $tarif)
                        <tr>
                            <td>{{ $tarif->id }}</td>
                            <td>{{ $tarif->type_vehicule }}</td>
                            <td>{{ $tarif->type_lavage }}</td>
                            <td>{{ number_format($tarif->prix, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('tarifs.edit', $tarif) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form action="{{ route('tarifs.destroy', $tarif) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
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
    @else
        <div class="alert alert-info text-center">
            Aucun tarif enregistré.
        </div>
    @endif
</div>
@endsection

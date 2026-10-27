@extends('layouts.app')

@section('title', 'Facturation Société')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-file-earmark-text"></i> Générer Facturation Société
    </h2>

    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">← Retour accueil</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('facturation.societe.resultat') }}">
        @csrf

        <div class="mb-3">
            <label for="societe">Société</label>
            <select name="societe_id" id="societe" class="form-select" required>
                <option value="">-- Choisir une société --</option>
                @foreach ($societes as $societe)
                    <option value="{{ $societe->id }}">{{ $societe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_debut">Date de début</label>
            <input type="date" name="date_debut" id="date_debut" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_fin">Date de fin</label>
            <input type="date" name="date_fin" id="date_fin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Voir résultats
        </button>
    </form>
</div>
@endsection

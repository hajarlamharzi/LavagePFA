@extends('layouts.app')

@section('title', 'Ajouter un Tarif')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-cash-coin me-2"></i> Ajouter un Tarif
    </h2>

    <a href="{{ route('tarifs.index') }}" class="btn btn-secondary mb-3">← Retour à la liste des Tarifs</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Veuillez corriger les erreurs ci-dessous :
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tarifs.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Type de véhicule</label>
            <select name="type_vehicule" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="moto" {{ old('type_vehicule') == 'moto' ? 'selected' : '' }}>Moto</option>
                <option value="petite_voiture" {{ old('type_vehicule') == 'petite_voiture' ? 'selected' : '' }}>Petite voiture</option>
                <option value="suv" {{ old('type_vehicule') == 'suv' ? 'selected' : '' }}>SUV</option>
                <option value="van" {{ old('type_vehicule') == 'van' ? 'selected' : '' }}>Van</option>
                <option value="berline" {{ old('type_vehicule') == 'berline' ? 'selected' : '' }}>Berline</option>
                <option value="voiture_utilitaire" {{ old('type_vehicule') == 'voiture_utilitaire' ? 'selected' : '' }}>Utilitaire</option>
                <option value="voiture_de_service" {{ old('type_vehicule') == 'voiture_de_service' ? 'selected' : '' }}>Voiture de Service</option>
            </select>
        </div>


        <div class="mb-3">
            <label class="form-label">Type de lavage</label>
            <input type="text" name="type_lavage" class="form-control" required value="{{ old('type_lavage') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Prix (MAD)</label>
            <input type="number" step="0.01" name="prix" class="form-control" required value="{{ old('prix') }}">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Enregistrer
        </button>
    </form>
</div>
@endsection

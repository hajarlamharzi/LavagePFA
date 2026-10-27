@extends('layouts.app')

@section('title', 'Modifier un employé')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Modifier l'employé : {{ $employe->prenom }} {{ $employe->nom }}</h2>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{-- Affichage des erreurs --}}
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

    {{-- Formulaire de modification --}}
    <form method="POST" action="{{ route('employes.update', $employe->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $employe->nom) }}" required>
        </div>

        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $employe->prenom) }}" required>
        </div>

        <div class="mb-3">
            <label>CIN</label>
            <input type="text" name="cin" class="form-control" value="{{ old('cin', $employe->cin) }}">
        </div>

        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $employe->telephone) }}">
        </div>

        <div class="mb-3">
            <label>Remarque</label>
            <textarea name="remarque" class="form-control" rows="3">{{ old('remarque', $employe->remarque) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('employes.index') }}" class="btn btn-secondary">← Retour</a>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection

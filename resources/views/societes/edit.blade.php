@extends('layouts.app')

@section('title', 'Modifier Société')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-building me-2"></i> Modifier Société
    </h2>

    <a href="{{ route('societes.index') }}" class="btn btn-secondary mb-3">
        ← Retour à la liste des Sociétés
    </a>

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

    <form method="POST" action="{{ route('societes.update', $societe) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la société <span class="text-danger">*</span></label>
            <input type="text" name="nom" id="nom" class="form-control" required value="{{ old('nom', $societe->nom) }}">
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control" value="{{ old('adresse', $societe->adresse) }}">
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $societe->telephone) }}">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Enregistrer les modifications
        </button>
    </form>
</div>
@endsection

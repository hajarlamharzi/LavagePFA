@extends('layouts.app')

@section('title', 'Ajouter un Employé')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Ajouter un employé</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cin" class="form-label">CIN</label>
            <input type="text" name="cin" class="form-control">
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="remarque" class="form-label">Remarque</label>
            <textarea name="remarque" class="form-control" rows="3" placeholder="Facultatif..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('employes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

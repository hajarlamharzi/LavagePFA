@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Ajouter une Avance</h2>

    <a href="{{ route('avances.index') }}" class="btn btn-secondary mb-3">← Retour à la liste</a>

    <form method="POST" action="{{ route('avances.store') }}">
        @csrf

        {{-- Employé --}}
        <div class="mb-3">
            <label for="employe_id">Employé</label>
            <select name="employe_id" class="form-select" required>
                <option value="">-- Choisir un employé --</option>
                @foreach($employes as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>

        {{-- Montant --}}
        <div class="mb-3">
            <label for="montant">Montant (en dirhams)</label>
            <input type="number" name="montant" step="0.01" class="form-control" required>
        </div>

        {{-- Remarque --}}
        <div class="mb-3">
            <label for="remarque">Remarque</label>
            <textarea name="remarque" class="form-control" rows="3" placeholder="Facultatif..."></textarea>
        </div>

        {{-- Bouton enregistrer --}}
        <button class="btn btn-success" type="submit">Enregistrer</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Modifier l'avance</h2>

    <form action="{{ route('avances.update', $avance->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Employé --}}
        <div class="mb-3">
            <label>Employé</label>
            <select name="employe_id" class="form-select" required>
                <option value="">-- Choisir un employé --</option>
                @foreach ($employes as $emp)
                    <option value="{{ $emp->id }}" {{ $emp->id == $avance->employe_id ? 'selected' : '' }}>
                        {{ $emp->prenom }} {{ $emp->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ $avance->date }}" required>
        </div>

        {{-- Montant --}}
        <div class="mb-3">
            <label>Montant</label>
            <input type="number" name="montant" class="form-control" value="{{ $avance->montant }}" step="0.01" required>
        </div>

        {{-- Remarque --}}
        <div class="mb-3">
            <label>Remarque</label>
            <textarea name="remarque" class="form-control" rows="3">{{ $avance->remarque }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('avances.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4"><i class="bi bi-pencil-square me-2"></i>Modifier Présence</h2>

    <form method="POST" action="{{ route('presences.update', $presence->id) }}">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Employé</label>
                <select name="employe_id" class="form-select" required>
                    @foreach($employes as $emp)
                        <option value="{{ $emp->id }}" {{ $emp->id == $presence->employe_id ? 'selected' : '' }}>
                            {{ $emp->prenom }} {{ $emp->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $presence->date }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">État</label>
                <select name="etat" class="form-select" required>
                    <option value="présent" {{ $presence->etat == 'présent' ? 'selected' : '' }}>Présent</option>
                    <option value="absent" {{ $presence->etat == 'absent' ? 'selected' : '' }}>Absent</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Heure d'entrée</label>
                <input type="time" name="heure_entree" class="form-control" value="{{ $presence->heure_entree }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Remarque</label>
            <input type="text" name="remarque" class="form-control" value="{{ $presence->remarque }}">
        </div>

        <div class="text-end">
            <button class="btn btn-success"><i class="bi bi-save me-1"></i>Enregistrer</button>
        </div>
    </form>
</div>
@endsection

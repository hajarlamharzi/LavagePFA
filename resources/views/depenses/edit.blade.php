@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Modifier la Dépense</h2>

    <form action="{{ route('depenses.update', $depense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Type de dépense</label>
            <select name="type" id="type" class="form-select" required>
                @foreach($types as $t)
                    <option value="{{ $t }}" {{ $depense->type === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="autre_type_container" style="display: {{ $depense->type === 'autre' ? 'block' : 'none' }};">
            <label>Autre type</label>
            <input type="text" name="autre_type" class="form-control" value="{{ $depense->autre_type }}">
        </div>

        <div class="mb-3">
            <label>Montant</label>
            <input type="number" name="montant" class="form-control" step="0.01" value="{{ $depense->montant }}" required>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ $depense->date }}" required>
        </div>

        <div class="mb-3">
            <label>Remarque</label>
            <textarea name="remarque" class="form-control">{{ $depense->remarque }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('depenses.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const autre = this.value === 'autre';
        document.getElementById('autre_type_container').style.display = autre ? 'block' : 'none';
    });
</script>
@endsection

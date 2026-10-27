@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Ajouter une Dépense</h2>

    <form action="{{ route('depenses.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Type de dépense</label>
            <select name="type" id="type" class="form-select" required>
                @foreach($types as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="autre_type_container" style="display: none;">
            <label>Autre type</label>
            <input type="text" name="autre_type" class="form-control" placeholder="Précisez le type de dépense">
        </div>

        <div class="mb-3">
            <label>Montant</label>
            <input type="number" name="montant" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label>Remarque</label>
            <textarea name="remarque" class="form-control"></textarea>
        </div>

        <button class="btn btn-success" type="submit">Enregistrer</button>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const autre = this.value === 'autre';
        document.getElementById('autre_type_container').style.display = autre ? 'block' : 'none';
    });
</script>
@endsection

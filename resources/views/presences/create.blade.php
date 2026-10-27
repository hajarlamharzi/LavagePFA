<form method="POST" action="{{ route('presences.store') }}" class="card p-4 shadow-sm">
    @csrf
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Employé</label>
            <select name="employe_id" class="form-select" required>
                <option value="">-- Sélectionnez un employé --</option>
                @foreach($employes as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Heure</label>
            <input type="time" name="heure_prestation" class="form-control" value="{{ date('H:i') }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">État</label>
            <select name="etat" class="form-select" required>
                <option value="présent">Présent</option>
                <option value="absent">Absent</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-10">
            <label class="form-label">Remarque</label>
            <input type="text" name="remarque" class="form-control" placeholder="Remarque (optionnel)">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Enregistrer</button>
        </div>
    </div>
</form>

@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex align-items-center">
            <i class="bi bi-cash-coin fs-3 me-2"></i>
            <h4 class="mb-0">Calcul des Dépenses</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('depenses.calcul') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-list-ul me-1"></i> Mode d'affichage</label>
                        <select name="mode" id="mode" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            <option value="intervalle" {{ old('mode', $request->mode) === 'intervalle' ? 'selected' : '' }}>Entre deux dates</option>
                            <option value="mois" {{ old('mode', $request->mode) === 'mois' ? 'selected' : '' }}>Par mois</option>
                        </select>
                    </div>
                </div>

                <div id="dates-range" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label><i class="bi bi-calendar-date me-1"></i> Date début</label>
                            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label><i class="bi bi-calendar-date-fill me-1"></i> Date fin</label>
                            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}">
                        </div>
                    </div>
                </div>

                <div id="mois-select" style="display: none;">
                    <div class="mb-3">
                        <label><i class="bi bi-calendar2-month me-1"></i> Mois</label>
                        <input type="month" name="mois_selectionne" class="form-control" value="{{ old('mois_selectionne') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-calculator me-1"></i> Calculer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (!empty($depenses) && $depenses->count())
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-bar-chart-steps me-1"></i> {{ $titre }}</h5>
            <p><strong>Total :</strong> <span class="text-success">{{ number_format($total, 2) }} DH</span></p>

            <h6 class="mt-4"><i class="bi bi-card-list me-1"></i> Liste des Dépenses</h6>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-calendar-event me-1"></i> Date</th>
                        <th><i class="bi bi-tag me-1"></i> Type</th>
                        <th><i class="bi bi-currency-dollar me-1"></i> Montant</th>
                        <th><i class="bi bi-chat-left-text me-1"></i> Remarque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($depenses as $depense)
                        <tr>
                            <td>{{ $depense->date }}</td>
                            <td>{{ $depense->type === 'autre' ? $depense->autre_type : $depense->type }}</td>
                            <td>{{ number_format($depense->montant, 2) }}</td>
                            <td>{{ $depense->remarque }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="alert alert-warning mt-4 text-center">
        <i class="bi bi-info-circle me-1"></i>
        Aucune dépense trouvée pour cette période.
    </div>
@endif

</div>

<!-- Script pour afficher dynamiquement les champs -->
<script>
    function toggleFields() {
        const mode = document.getElementById('mode').value;
        document.getElementById('dates-range').style.display = (mode === 'intervalle') ? 'block' : 'none';
        document.getElementById('mois-select').style.display = (mode === 'mois') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', toggleFields);
    document.getElementById('mode').addEventListener('change', toggleFields);
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center"><i class="bi bi-cash-stack me-2"></i>Calcul des Avances</h2>
    <a href="{{ route('avances.index') }}" class="btn btn-secondary mb-3">
        ← Retour à la liste des Avances
    </a>

    <form method="POST" action="{{ route('avances.calcul') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-calendar-date me-1"></i> Date début</label>
                <input type="date" name="date_debut" class="form-control"
                    value="{{ old('date_debut', $request->date_debut ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="bi bi-calendar-date-fill me-1"></i> Date fin</label>
                <input type="date" name="date_fin" class="form-control"
                    value="{{ old('date_fin', $request->date_fin ?? '') }}" required>
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary"><i class="bi bi-calculator me-1"></i>Calculer</button>
        </div>
    </form>

    @if(request()->isMethod('post'))
        <hr>

        @if ($avances->count())
            <h4 class="mt-4">
                <i class="bi bi-currency-exchange me-1"></i>
                Total : <strong>{{ number_format($total, 2) }} DH</strong>
            </h4>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Employé</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Remarque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($avances as $av)
                            <tr>
                                <td>{{ $av->employe->prenom }} {{ $av->employe->nom }}</td>
                                <td>{{ $av->date }}</td>
                                <td>{{ number_format($av->montant, 2) }} DH</td>
                                <td>{{ $av->remarque }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-4 text-center">
                <i class="bi bi-info-circle me-2"></i> Aucune avance trouvée pour cette période.
            </div>
        @endif
        @if ($totauxParEmploye->count())
    <h5 class="mt-4">
        <i class="bi bi-person-lines-fill me-1"></i>
        Totaux par Employé
    </h5>

    <div class="table-responsive mt-2">
        <table class="table table-bordered table-striped">
            <thead class="table-secondary">
                <tr>
                    <th>Employé</th>
                    <th>Total Avances</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totauxParEmploye as $item)
                    <tr>
                        <td>{{ $item['employe']->prenom }} {{ $item['employe']->nom }}</td>
                        <td>{{ number_format($item['total'], 2) }} DH</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

    @endif
</div>
@endsection

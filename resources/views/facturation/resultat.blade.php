@extends('layouts.app')

@section('title', 'Résultat Facturation')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-receipt"></i> Résultat Facturation
    </h2>

    <a href="{{ route('facturation.societe') }}" class="btn btn-secondary mb-3">← Nouvelle recherche</a>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Société : <strong>{{ $societe->nom }}</strong></h5>
            <p>Période : <strong>{{ $request->date_debut }}</strong> au <strong>{{ $request->date_fin }}</strong></p>
        </div>
    </div>

    @if ($prestations->count())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Marque</th>
                        <th>Matricule</th>
                        <th>Prix (MAD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestations as $p)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($p->date_prestation)->format('d/m/Y') }}</td>
                            <td>{{ $p->marque }}</td>
                            <td>{{ $p->matricule }}</td>
                            <td>{{ number_format($p->prix, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h4 class="mt-3 text-end">Total : <span class="text-success">{{ number_format($total, 2) }} MAD</span></h4>
    @else
        <div class="alert alert-info">
            Aucune prestation trouvée pour cette période.
        </div>
    @endif

    <a href="{{ route('facturation.societe') }}" class="btn btn-secondary mt-3">← Retour</a>
</div>
@endsection

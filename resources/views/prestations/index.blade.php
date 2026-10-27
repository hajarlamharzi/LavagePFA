@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp
@section('content')
<style>
    .pagination {
        font-size: 0.9rem;
    }
    .pagination .page-link {
        padding: 0.25rem 0.5rem;
    }
    </style>

<div class="container mt-5">

    {{-- Titre + bouton --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">🧼 Liste des prestations</h2>
        <a href="{{ route('vehicules.select') }}" class="btn btn-success shadow-sm">
            + Nouvelle Prestation
        </a>
    </div>
{{-- Formulaire de recherche --}}
<form method="GET" action="{{ route('prestations.index') }}" class="card p-3 mb-4 shadow-sm">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="matricule" class="form-label">Matricule</label>
            <input type="text" name="matricule" id="matricule" value="{{ request('matricule') }}" class="form-control" placeholder="Ex: 12345-A-6">
        </div>

        <div class="col-md-4">
            <label for="marque" class="form-label">Marque</label>
            <input type="text" name="marque" id="marque" value="{{ request('marque') }}" class="form-control" placeholder="Ex: Peugeot">
        </div>

        <div class="col-md-4">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="form-control">
        </div>

        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2">🔍 Rechercher</button>
            <a href="{{ route('prestations.index') }}" class="btn btn-outline-secondary">🔄 Réinitialiser</a>
        </div>
    </div>
</form>

    {{-- Tableau stylisé --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>N°</th>
                            <th>Matricule</th>
                            <th>Marque</th>
                            <th>Type véhicule</th>
                            <th>Type lavage</th>
                            <th>Prix</th>
                            <th>Date</th>
                            <th>Employé</th>
                            <th>Statut Paiement</th>
                            <th>Client</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($prestations as $p)
                            <tr>
                                <td><span class="badge bg-primary">{{ $p->numero }}</span></td>
                                <td>{{ $p->matricule }}</td>
                                <td>{{ $p->marque }}</td>
                                <td>{{ ucfirst($p->type_vehicule) }}</td>
                             <td>
 @php
    $decoded = json_decode($p->type_lavage, true);
@endphp


    @if(json_last_error() === JSON_ERROR_NONE && is_array($decoded))
        @foreach ($decoded as $lav)
            {{ ucfirst($lav['type_lavage']) }} ({{ number_format($lav['prix'], 2) }} DH)@if (!$loop->last), @endif
        @endforeach
    @else
      {{ $p->type_lavage }}

    @endif
</td>

                                <td><strong>{{ $p->prix }} DH</strong></td>
                                <td>{{ \Carbon\Carbon::parse($p->date_prestation)->format('d/m/Y') }}</td>
                                <td>{{ $p->employe->prenom ?? '-' }}</td>
                                <td>{{ $p->statut_paiement }}</td>
                                <td>
                                    @if ($p->societe)
                                        <span class="text-info">{{ $p->societe->nom }}</span>
                                    @else
                                        <span class="text-muted">Particulier</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('prestations.ticket', $p->id) }}" class="btn btn-outline-secondary btn-sm">
                                        🖨️ Ticket
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted">Aucune prestation trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $prestations->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

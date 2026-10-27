@extends('layouts.app')

@section('title', 'Gestion des Réservations')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">
        <i class="bi bi-calendar-event-fill me-2"></i> Gestion des Réservations Clients
    </h2>

    <!-- Filtre -->
    <form method="GET" class="card mb-4 p-3 shadow-sm">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Type de lavage</label>
                <select name="type_lavage" class="form-select">
                    <option value="">-- Tous --</option>
                    <option value="express" {{ request('type_lavage') == 'express' ? 'selected' : '' }}>Express</option>
                    <option value="complet" {{ request('type_lavage') == 'complet' ? 'selected' : '' }}>Complet</option>
                    <option value="intérieur" {{ request('type_lavage') == 'intérieur' ? 'selected' : '' }}>Intérieur</option>
                    <option value="extérieur" {{ request('type_lavage') == 'extérieur' ? 'selected' : '' }}>Extérieur</option>
                    <option value="moteur" {{ request('type_lavage') == 'moteur' ? 'selected' : '' }}>Moteur</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button class="btn btn-outline-primary flex-grow-1">
                    <i class="bi bi-funnel-fill"></i> Filtrer
                </button>
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Réinitialiser
                </a>
            </div>
        </div>
    </form>

    @if($reservations->isEmpty())
        <div class="alert alert-warning text-center">Aucune réservation trouvée.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Client</th>
                        <th>Téléphone</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Type Lavage</th>
                        <th>Remarque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                        <tr>
                            <td>{{ $res->nom }}</td>
                            <td>{{ $res->telephone }}</td>
                            <td>{{ $res->date }}</td>
                            <td>{{ $res->heure }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($res->type_lavage) }}
                                </span>
                            </td>
                            <td>{{ $res->remarque ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $reservations->links() }}
        </div>
    @endif
</div>
@endsection

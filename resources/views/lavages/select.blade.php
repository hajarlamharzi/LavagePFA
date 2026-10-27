@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">
        <i class="bi bi-car-front-fill"></i>
        Choisissez un type de lavage pour :
        <strong class="text-primary text-uppercase">{{ str_replace('_', ' ', $typeVehicule) }}</strong>
    </h2>

    <div class="d-flex justify-content-between mb-2">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('vehicules.select') }}" class="btn btn-outline-secondary">
            ← Retour aux Prestations
        </a>
    </div>

    @php $moteurShown = false; @endphp

    @if ($lavages->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-triangle-fill"></i> Aucun type de lavage trouvé pour le véhicule sélectionné.
        </div>
    @else
    <form method="GET" action="{{ route('prestations.create') }}" id="lavageForm">
        <input type="hidden" name="type_vehicule" value="{{ $typeVehicule }}">

        <div class="row justify-content-center">
            @foreach ($lavages as $lavage)
                @php
                    // Choisir l'icône selon le type de lavage
                    $icone = 'bi-droplet-half';
                    if (str_contains($lavage->type_lavage, 'moteur')) $icone = 'bi-gear-fill';
                    elseif (str_contains($lavage->type_lavage, 'intérieur')) $icone = 'bi-house';
                    elseif (str_contains($lavage->type_lavage, 'extérieur')) $icone = 'bi-sun';
                    elseif (str_contains($lavage->type_lavage, 'complet')) $icone = 'bi-check-circle-fill';
                @endphp

                <div class="col-md-4 col-lg-4 mb-4">
                    <div class="card h-100 text-center shadow border-0 lavage-card" data-id="{{ $lavage->id }}">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">
                                    <i class="bi {{ $icone }} me-1"></i>
                                    {{ ucfirst($lavage->type_lavage) }}
                                </h5>
                                <p class="card-text text-success fs-4">
                                    <i class="bi bi-currency-exchange"></i> {{ number_format($lavage->prix, 2) }} MAD
                                </p>
                                <p class="text-muted">
                                    <i class="bi bi-car-front"></i> {{ ucfirst(str_replace('_', ' ', $typeVehicule)) }}
                                </p>

                               
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <input type="hidden" name="lavages" id="selectedLavages">

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-check2-square"></i> Valider la sélection
            </button>
        </div>
    </form>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectedIds = new Set();
        const cards = document.querySelectorAll('.lavage-card');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const id = card.getAttribute('data-id');
                if (selectedIds.has(id)) {
                    selectedIds.delete(id);
                    card.classList.remove('selected');
                } else {
                    selectedIds.add(id);
                    card.classList.add('selected');
                }
                document.getElementById('selectedLavages').value = Array.from(selectedIds).join(',');
            });
        });
    });
</script>
@endpush

<style>
    h2 {
        font-size: 2.5rem;
        text-align: center;
        font-weight: bold;
        margin-bottom: 2rem;
    }

    .card-title {
        font-size: 2rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1.8rem;
        color: #198754;
    }

    .lavage-card {
        cursor: pointer;
        transition: border 0.3s, box-shadow 0.3s;
    }

    .lavage-card:hover {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 10px rgba(13,110,253,0.3);
    }

    .lavage-card.selected {
        border: 2px solid #198754;
        box-shadow: 0 0 10px rgba(25,135,84,0.5);
        background-color: #e9f7ef;
    }

    .btn {
        font-size: 1.3rem;
    }

    .form-check-label {
        font-size: 1.1rem;
    }
</style>
@endsection

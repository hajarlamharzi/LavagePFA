@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4"><i class="bi bi-graph-up-arrow me-2"></i> Rapport Financier</h2>

    {{-- 📅 Formulaire de sélection de date --}}
    <form method="POST" action="{{ route('rapport.calcul') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Date début</label>
                <input type="date" name="date_debut" class="form-control"
       value="{{ old('date_debut', session('rapport_date_debut', $debut)) }}">



            </div>
            <div class="col-md-6">
                <label class="form-label">Date fin</label>
               <input type="date" name="date_fin" class="form-control"
       value="{{ old('date_fin', session('rapport_date_fin', $fin)) }}">
            </div>
        </div>
        <div class="text-end">
            <button class="btn btn-primary">
                <i class="bi bi-calculator me-1"></i> Calculer
            </button>
        </div>
    </form>

    @isset($totaux)
    {{-- 📊 Résumé sous forme de cartes --}}
    <div class="row text-center mt-5">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="bi bi-car-front-fill me-1"></i> Lavages</h5>
                    <p class="fs-4 text-primary">{{ number_format($totaux['lavages'], 2) }} DH</p>
                    <a href="{{ route('rapport.details', ['type' => 'lavages', 'date_debut' => $debut, 'date_fin' => $fin]) }}"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye-fill me-1"></i> Détails
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="bi bi-wallet2 me-1"></i> Dépenses</h5>
                    <p class="fs-4 text-danger">{{ number_format($totaux['depenses'], 2) }} DH</p>
                    <a href="{{ route('rapport.details', ['type' => 'depenses', 'date_debut' => $debut, 'date_fin' => $fin]) }}"
                       class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-eye-fill me-1"></i> Détails
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="bi bi-cash-stack me-1"></i> Avances</h5>
                    <p class="fs-4 text-warning">{{ number_format($totaux['avances'], 2) }} DH</p>
                    <a href="{{ route('rapport.details', ['type' => 'avances', 'date_debut' => $debut, 'date_fin' => $fin]) }}"
                       class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-eye-fill me-1"></i> Détails
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="bi bi-calculator me-1"></i> Solde</h5>
                    <p class="fs-4 text-success">{{ number_format($totaux['solde'], 2) }} DH</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 🧾 Résumé détaillé --}}
    <hr>
    <h4 class="text-success mt-4">Résultat du {{ $debut }} au {{ $fin }}</h4>
    <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between">
            <span><i class="bi bi-cash-coin me-2 text-success"></i> Total Lavages</span>
            <strong>{{ number_format($totaux['lavages'], 2) }} DH</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span><i class="bi bi-wallet2 me-2 text-danger"></i> Total Dépenses</span>
            <strong>{{ number_format($totaux['depenses'], 2) }} DH</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span><i class="bi bi-people me-2 text-warning"></i> Total Avances</span>
            <strong>{{ number_format($totaux['avances'], 2) }} DH</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between bg-light">
            <span><i class="bi bi-bar-chart-line me-2 text-info"></i> Solde Final</span>
            <strong>{{ number_format($totaux['solde'], 2) }} DH</strong>
        </li>
    </ul>
    @endisset
</div>
@endsection

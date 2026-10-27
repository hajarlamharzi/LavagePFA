@extends('layouts.client')

@section('content')


<style>
    .reservation-header {
        background: linear-gradient(to right, #0d1b2a, #1b263b);
        color: #f1c40f;
        padding: 2rem;
        text-align: center;
    }
    .reservation-header h1 {
        font-weight: bold;
    }
    .card-reservation {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .btn-gold {
        background-color: #f1c40f;
        border: none;
        color: #000;
    }
    .btn-gold:hover {
        background-color: #d4ac0d;
        color: #fff;
    }
</style>

<div class="reservation-header">
    <h1><i class="bi bi-calendar-plus"></i> Réserver un Rendez-vous</h1>
    <p class="lead">Planifiez votre lavage en quelques clics</p>
</div>

<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="card card-reservation p-4">
        <form method="POST" action="{{ route('reservation.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom Complet</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="telephone" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Type de véhicule</label>
                    <select name="type_vehicule" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="petite_voiture">Petite Voiture</option>
                        <option value="berline">Berline</option>
                        <option value="SUV">SUV</option>
                        <option value="moto">Moto</option>
                        <option value="utilitaire">Utilitaire</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Services souhaités</label>
                    <select name="services[]" class="form-select" multiple required>
                        <option value="express">Lavage Express</option>
                        <option value="complet">Lavage Complet</option>
                        <option value="interieur">Intérieur</option>
                        <option value="extra">Extra</option>
                        <option value="special">Spécial</option>
                    </select>
                    <small class="text-muted">Maintenez CTRL pour sélectionner plusieurs.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date du rendez-vous</label>
                    <input type="date" name="date_reservation" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Heure souhaitée</label>
                    <input type="time" name="heure_reservation" class="form-control" required>
                </div>
            </div>


            <div class="text-end mt-4">
                <button class="btn btn-gold btn-lg">
                    <i class="bi bi-calendar-check me-1"></i> Confirmer la réservation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

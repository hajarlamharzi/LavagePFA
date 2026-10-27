@extends('layouts.app')

@section('title', 'Réserver un lavage')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4 text-primary">
        <i class="bi bi-calendar-plus-fill me-2"></i> Réserver un rendez-vous lavage
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" name="nom" value="{{ old('nom') }}" class="form-control @error('nom') is-invalid @enderror" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-control @error('telephone') is-invalid @enderror" required>
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Date souhaitée <span class="text-danger">*</span></label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Heure <span class="text-danger">*</span></label>
                        <input type="time" name="heure" value="{{ old('heure') }}" class="form-control @error('heure') is-invalid @enderror" required>
                        @error('heure')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Type de lavage <span class="text-danger">*</span></label>
                        <select name="type_lavage" class="form-select @error('type_lavage') is-invalid @enderror" required>
                            <option value="">-- Choisir --</option>
                            <option value="express" {{ old('type_lavage') == 'express' ? 'selected' : '' }}>Express</option>
                            <option value="complet" {{ old('type_lavage') == 'complet' ? 'selected' : '' }}>Complet</option>
                            <option value="intérieur" {{ old('type_lavage') == 'intérieur' ? 'selected' : '' }}>Intérieur</option>
                            <option value="extérieur" {{ old('type_lavage') == 'extérieur' ? 'selected' : '' }}>Extérieur</option>
                            <option value="moteur" {{ old('type_lavage') == 'moteur' ? 'selected' : '' }}>Moteur</option>
                        </select>
                        @error('type_lavage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Remarque (optionnelle)</label>
                    <textarea name="remarque" class="form-control">{{ old('remarque') }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check2-circle"></i> Valider ma réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

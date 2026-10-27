@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<style>
    /* Spécial image moto */
    .moto-img {
        height: 210px !important;
        object-fit: contain;
        padding: 10px;
    }

    /* Animation au survol */
    .hover-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .hover-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    /* Titre plus grand et plus gras */
    .card-title {
        font-size: 1.6rem;
        font-weight: 600;
    }

    /* Optionnel : agrandir police globale dans les cartes */
    .card {
        font-size: 1.05rem;
    }



</style>

<div class="container mt-4">
    {{-- Message de succès si redirection après store --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-center mb-4">Choisissez le type de véhicule</h2>

    <div class="row justify-content-center">
        @foreach ($types as $type)
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ url('/lavage/select?type_vehicule=' . $type['nom']) }}" style="text-decoration: none;">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <img
                            src="{{ Str::startsWith($type['image'], 'http') ? $type['image'] : asset('images/vehicules/' . $type['image']) }}"
                            class="card-img-top {{ $type['nom'] === 'moto' ? 'moto-img' : '' }}"
                            alt="{{ $type['nom'] }}"
                            style="height: 220px; object-fit: contain;">
                        <div class="card-body text-center">
                            <h5 class="card-title text-capitalize">
                                {{ ucwords(str_replace('_', ' ', $type['nom'])) }}
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection

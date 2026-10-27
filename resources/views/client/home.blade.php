@extends('layouts.client')


@section('content')
<div class="container-fluid p-0">

    {{-- ✅ Hero Section --}}
    <section class="hero position-relative text-center text-white d-flex align-items-center" style="background: url('{{ asset('images/car-wash-banner.jpg') }}') center/cover;">
        <div class="overlay" style="background-color: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0;"></div>
        <div class="container position-relative py-5">
            <h1 class="display-2 fw-bold text-success">🌿 Green Car Wash 🌿</h1>
            <p class="lead mb-4">Propreté, qualité et service premium pour votre véhicule</p>
            <a href="{{ route('reservation.form') }}" class="btn btn-success btn-lg shadow-lg">
                <i class="bi bi-calendar-plus"></i> Réservez votre lavage
            </a>
        </div>
    </section>

    {{-- ✅ Nos Services --}}
    <section class="py-5">
        <div class="container text-center">
            <h2 class="text-success fw-bold mb-4">🚗 Nos Services</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-droplet-half display-3 text-success mb-3"></i>
                            <h5 class="fw-bold">Lavage Express</h5>
                            <p class="text-muted">Un nettoyage rapide et soigné, idéal pour l'entretien quotidien de votre véhicule.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-car-front-fill display-3 text-success mb-3"></i>
                            <h5 class="fw-bold">Lavage Complet</h5>
                            <p class="text-muted">Intérieur et extérieur nettoyés avec soin. Notre service le plus demandé.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-stars display-3 text-success mb-3"></i>
                            <h5 class="fw-bold">Lavage Premium</h5>
                            <p class="text-muted">Finitions haut de gamme et détails minutieux pour les clients exigeants.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ✅ Pourquoi Nous Choisir --}}
    <section class="bg-success text-white py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Pourquoi Choisir Green Car Wash ?</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <ul class="list-unstyled lead mb-4">
                        <li class="mb-2">✔️ Rapidité et qualité inégalées</li>
                        <li class="mb-2">✔️ Produits éco-responsables</li>
                        <li class="mb-2">✔️ Équipe professionnelle et accueil chaleureux</li>
                    </ul>
                    <a href="{{ route('reservation.form') }}" class="btn btn-light btn-lg shadow">
                        <i class="bi bi-calendar-plus"></i> Réservez Maintenant
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ✅ Bandeau Appel à l'action --}}
    <section class="bg-dark text-white py-4">
        <div class="container text-center">
            <h3 class="mb-3">Prêt à chouchouter votre voiture ?</h3>
            <a href="{{ route('reservation.form') }}" class="btn btn-success btn-lg">
                <i class="bi bi-calendar-event"></i> Prenez Rendez-vous
            </a>
        </div>
    </section>

    {{-- ✅ Footer --}}
    <footer class="bg-dark text-white text-center py-3">
        <small>&copy; {{ date('Y') }} Green Car Wash. Tous droits réservés.</small>
    </footer>

</div>
@endsection

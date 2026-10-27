<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Application de Lavage')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-md">

            <a class="navbar-brand" href="{{ route('home') }}">Comptabilité Lavage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    @if(session()->has('user_id'))
                        <!-- ✅ Affichage Nom et Rôle -->
                        <li class="nav-item">
                            <span class="navbar-text text-warning">
                                Bonjour, {{ session('user_nom') }} ({{ session('user_role') }})
                            </span>
                        </li>

                        <!-- ✅ Liens communs pour TOUS -->
                     @if(auth()->check())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('vehicules.select') }}">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle Prestation
        </a>
    </li>
@endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('prestations.index') }}">
                                <i class="bi bi-card-checklist me-1"></i> Liste des Prestations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('depenses.index') }}">
                                <i class="bi bi-wallet2 me-1"></i> Dépenses
                            </a>
                        </li>

                        @if(session('user_role') === 'admin')

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employes.index') }}">
                                    <i class="bi bi-people me-1"></i> Employés
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('avances.index') }}">
                                    <i class="bi bi-cash-coin me-1"></i> Avances
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rapport.calcul') }}">
                                    <i class="bi bi-graph-up me-1"></i> Rapport
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('societes.index') }}">
                                    <i class="bi bi-building me-1"></i> Sociétés
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tarifs.index') }}">
                                    <i class="bi bi-cash-coin me-1"></i> Tarifs
                                </a>
                            </li>
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('presences.index') }}">
                                    <i class="bi bi-cash-coin me-1"></i> Presences
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('facturation.societe') }}">
                                    <i class="bi bi-receipt me-1"></i>
                                    <span>Facturation Sociétés</span>
                                </a>
                            </li>


                        @endif

                        <!-- ✅ Logout -->
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="nav-link btn btn-link text-decoration-none" type="submit">
                                    <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                                </button>
                            </form>
                        </li>

                    @else
                        <!-- ✅ Si pas connecté -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-person-circle me-1"></i> Connexion
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu -->
    <main class="container-md">
        @yield('content')
        @if (session('success'))
            <div class="alert alert-success text-center mt-4">
                {{ session('success') }}
            </div>
        @endif
    </main>
    <style>
        @media (min-width: 992px) {
            .navbar .collapse:not(.show) {
                display: none !important;
            }
            .navbar-toggler {
                display: block !important;
            }
        }
    </style>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

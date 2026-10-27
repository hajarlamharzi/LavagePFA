@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Tableau de bord')

@section('content')
<div class="container my-4">
    <h2 class="text-center mb-4 text-primary fw-bold display-5">
    <i class="bi bi-house-door"></i> Tableau de bord général
</h2>
@if($notifications->count())
    <div class="alert alert-info">
        <strong>Notifications :</strong>
        <ul class="list-group mt-2">
            @foreach($notifications as $note)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $note->data['message'] }}
                    <form method="POST" action="{{ route('notifications.markAsRead', $note->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-success">Marquer comme lu</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endif


    {{-- ✅ Statistiques journalières --}}
    <div class="row g-3 mb-4 text-center">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-car-front-fill"></i> Lavages Aujourd’hui</h6>
                    <h4 class="text-primary">{{ number_format($lavagesDuJour ?? 0, 2) }} DH</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-wallet2"></i> Dépenses</h6>
                    <h4 class="text-danger">{{ number_format($depensesDuJour ?? 0, 2) }} DH</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-cash-stack"></i> Avances</h6>
                    <h4 class="text-warning">{{ number_format($avancesDuJour ?? 0, 2) }} DH</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-graph-up-arrow"></i> Solde</h6>
                    <h4 class="text-success">{{ number_format($solde ?? 0, 2) }} DH</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Employés actifs aujourd'hui --}}
    <hr>
<h4 class="mt-4 mb-3 text-success fw-bold">
    <i class="bi bi-people-fill"></i> Employés Actifs Aujourd’hui
</h4>
    @if($employesActifs->count())
        <ul class="list-group mb-4">
            @foreach ($employesActifs as $e)
                <li class="list-group-item">{{ $e->prenom }} {{ $e->nom }}</li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-secondary text-center">
            Aucun employé actif aujourd'hui.
        </div>
    @endif

    {{-- ✅ Dernières prestations --}}
    @if($recentPrestations->count())
        <hr>
<h4 class="mt-4 mb-3 text-info fw-bold">
    <i class="bi bi-clock-history"></i> Dernières Prestations Récentes
</h4>
        <div class="table-responsive">
            <table class="table table-sm table-bordered mt-2">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Véhicule</th>
                        <th>Lavage</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentPrestations as $p)
                        <tr>
                            <td>{{ $p->date_prestation }}</td>
                            <td>{{ $p->marque }} ({{ $p->matricule }})</td>
                            <td>
                                @php $decoded = json_decode($p->type_lavage, true); @endphp
                                @if(is_array($decoded))
                                    @foreach($decoded as $lav)
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst($lav['type_lavage']) }} ({{ number_format($lav['prix'], 2) }} DH)
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge bg-info text-dark">{{ ucfirst($p->type_lavage) }}</span>
                                @endif
                            </td>
                            <td>{{ number_format($p->prix, 2) }} DH</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
 {{-- ✅ Graphiques par heurs --}}
<hr class="my-4">
<h4 class="text-center mb-4 text-primary fw-bold fs-3">
    <i class="bi bi-bar-chart-line-fill me-2"></i> Statistiques du Mois
</h4>

<div class="row gx-4 gy-4">
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-warning text-dark fw-bold fs-5">
                <i class="bi bi-clock-history me-2"></i> Heures de pointe aujourd'hui
            </div>
            <div class="card-body">
                <canvas id="heuresChart" style="width:100%; height:350px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-danger text-white fw-bold fs-5">
                <i class="bi bi-pie-chart-fill me-2"></i> Répartition des Lavages du Mois
            </div>
            <div class="card-body">
                <canvas id="lavagesChart" style="width:100%; height:350px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Graphique Lavages du Mois
    new Chart(document.getElementById('lavagesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($lavageCounts ?? [])) !!},
            datasets: [{
                label: 'Commandes du mois',
                data: {!! json_encode(array_values($lavageCounts ?? [])) !!},
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    // ✅ Nouveau graphique Heures de pointe
    new Chart(document.getElementById('heuresChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($heures ?? []) !!},
            datasets: [{
                label: 'Nombre de prestations',
                data: {!! json_encode($totauxParHeure ?? []) !!},
                fill: true,
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                borderColor: '#198754',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true },
                x: { title: { display: true, text: 'Heure de la journée' } }
            }
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    new Chart(document.getElementById('lavagesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($lavageCounts ?? [])) !!},
            datasets: [{
                label: 'Commandes du mois',
                data: {!! json_encode(array_values($lavageCounts ?? [])) !!},
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endsection

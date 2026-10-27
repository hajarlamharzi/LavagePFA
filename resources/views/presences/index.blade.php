@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ✅ Alertes de session toujours en haut --}}
@once
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endonce

@once
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endonce


    <h2 class="text-center mb-4">
        <i class="bi bi-calendar-check me-2"></i> Gestion des Présences
    </h2>

    <!-- ✅ Formulaire d'enregistrement -->
    <div class="card shadow-sm rounded mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('presences.store') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Employé</label>
                        <select name="employe_id" class="form-select" required>
                            @foreach($employes as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Heure d'entrée</label>
                        <input type="time" name="heure_entree" class="form-control" value="{{ date('H:i') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">État</label>
                        <select name="etat" class="form-select" required>
                            <option value="présent">Présent</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Remarque</label>
                        <input type="text" name="remarque" class="form-control" placeholder="Optionnel">
                    </div>
                </div>
                @if ($errors->has('duplicate'))
                    <div class="alert alert-warning mt-3">
                        {{ $errors->first('duplicate') }}
                    </div>
                @endif

                <div class="text-end mt-3">
                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Filtre par date -->
    <form method="GET" class="mb-4 row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Date début</label>
            <input type="date" name="start" class="form-control" value="{{ request('start') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin</label>
            <input type="date" name="end" class="form-control" value="{{ request('end') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-outline-primary flex-grow-1">
                <i class="bi bi-funnel-fill"></i> Filtrer
            </button>
            <a href="{{ route('presences.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Réinitialiser
            </a>
        </div>
    </form>

    <!-- ✅ Résumé des filtres -->
    @if(request('start') && request('end'))
        <div class="alert alert-info">
            Total de présences entre <strong>{{ request('start') }}</strong> et <strong>{{ request('end') }}</strong> :
            <strong>{{ $totalPresent }}</strong>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Présences par employé</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Employé</th>
                            <th>Nombre de jours présents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presenceParEmploye as $p)
                            <tr>
                                <td>{{ $p->employe->prenom }} {{ $p->employe->nom }}</td>
                                <td>{{ $p->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Aucune présence pour cette période.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- ✅ Liste des présences -->
    <h4 class="mt-4">
        <i class="bi bi-list-check me-2"></i> Historique des Présences
    </h4>
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Employé</th>
                    <th>Date</th>
                    <th>Heure d'entrée</th>
                    <th>État</th>
                    <th>Remarque</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presences as $p)
                    <tr>
                        <td>{{ $p->employe->prenom }} {{ $p->employe->nom }}</td>
                        <td>{{ $p->date }}</td>
                        <td>{{ $p->heure_entree }}</td>
                        <td>
                            @if ($p->etat === 'présent')
                                <span class="badge bg-success">Présent</span>
                            @else
                                <span class="badge bg-danger">Absent</span>
                            @endif
                        </td>
                        <td>{{ $p->remarque }}</td>
                        <td>
                            <a href="{{ route('presences.edit', $p->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune présence enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ✅ Pagination -->
    @if ($presences->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $presences->links() }}
        </div>
    @endif
</div>
@endsection

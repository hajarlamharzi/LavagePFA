@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ✅ Zone de navigation --}}
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('rapport.calcul', [
            'type' => $type,
            'date_debut' => $debut,
            'date_fin' => $fin
        ]) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour au rapport
        </a>
        <a href="{{ route('home') }}" class="btn btn-outline-dark">
            <i class="bi bi-house"></i> Dashboard
        </a>
    </div>

    {{-- ✅ Titre principal --}}
    <h2 class="text-center mb-4 fw-bold text-primary">
        <i class="bi bi-info-circle-fill me-2"></i> Détails des {{ ucfirst($type) }} du {{ $debut }} au {{ $fin }}
    </h2>

    @if ($data->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-triangle-fill"></i> Aucune donnée trouvée pour cette période.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    @if ($type === 'lavages')
                        <tr>
                            <th>Date</th>
                            <th>Employé</th>
                            <th>Type de Lavage</th>
                            <th>Véhicule</th>
                            <th>Prix</th>
                        </tr>
                    @elseif ($type === 'depenses')
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Remarque</th>
                        </tr>
                    @else
                        <tr>
                            <th>Date</th>
                            <th>Employé</th>
                            <th>Montant</th>
                            <th>Remarque</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            @if ($type === 'lavages')
                                <td class="text-center">{{ $item->date_prestation }}</td>
                                <td>{{ $item->employe->prenom }} {{ $item->employe->nom }}</td>

                                @php
                                    $couleurs = [
                                        'express'    => 'primary',
                                        'complet'    => 'success',
                                        'interieur'  => 'warning',
                                        'extra'      => 'danger',
                                        'special'    => 'info',
                                        'moto'       => 'secondary'
                                    ];
                                    $decoded = json_decode($item->type_lavage, true);
                                @endphp

                                <td>
                                    @if (is_array($decoded))
                                        @foreach ($decoded as $lav)
                                            <span class="badge bg-{{ $couleurs[$lav['type_lavage']] ?? 'dark' }} mb-1">
                                                {{ ucfirst($lav['type_lavage']) }} ({{ number_format($lav['prix'], 2) }} DH)
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-{{ $couleurs[$item->type_lavage] ?? 'dark' }}">
                                            {{ ucfirst($item->type_lavage) }}
                                        </span>
                                    @endif
                                </td>

                                <td>{{ $item->matricule }} ({{ $item->marque }})</td>
                                <td class="text-end">
                                    @if ($item->type_vehicule === 'voiture_de_service')
                                        <span class="text-muted"><i class="bi bi-ticket-perforated"></i> Bon Société</span>
                                    @else
                                        {{ number_format($item->prix, 2) }} DH
                                    @endif
                                </td>

                            @elseif ($type === 'depenses')
                                <td class="text-center">{{ $item->date }}</td>
                                <td>{{ $item->type === 'autre' ? $item->autre_type : $item->type }}</td>
                                <td class="text-end">{{ number_format($item->montant, 2) }} DH</td>
                                <td>{{ $item->remarque }}</td>

                            @else
                                <td class="text-center">{{ $item->date }}</td>
                                <td>{{ $item->employe->prenom }} {{ $item->employe->nom }}</td>
                                <td class="text-end">{{ number_format($item->montant, 2) }} DH</td>
                                <td>{{ $item->remarque }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

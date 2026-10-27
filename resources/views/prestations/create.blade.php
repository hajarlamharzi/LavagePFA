@extends('layouts.app')


@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-check2-square me-2"></i> Finaliser la prestation
    </h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('prestations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-list-ul"></i> Voir toutes les prestations
        </a>
        <a href="{{ route('vehicules.select') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Retour aux véhicules
        </a>
    </div>
</div>


    {{-- FORMULAIRE --}}
    <form id="prestationForm" novalidate>
        @csrf

<div id="confirmationBox" class="card text-center p-4 my-4 shadow" style="display: none;">
    <h5 class="mb-3 text-success">
        <i class="bi bi-check-circle-fill"></i> Prestation enregistrée !
    </h5>
    <p class="mb-4">Voulez-vous imprimer le ticket ?</p>
    <div class="d-flex justify-content-center gap-3">
        <a id="btnImprimerTicket" href="#" class="btn btn-success">
            <i class="bi bi-printer-fill"></i> Oui, imprimer le ticket
        </a>
        <a href="{{ route('vehicules.select') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Non, revenir aux véhicules
        </a>
    </div>
</div>
     {{-- Type de véhicule --}}
<div class="card mb-4 p-3 shadow-sm">
   <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <i class="bi bi-truck-front-fill"></i>
        Véhicule : <strong>{{ $typeVehicule }}</strong>
    </div>
    <div class="d-flex align-items-center">
        <i class="bi bi-calendar-date me-1"></i>
        <input type="date" name="date_prestation" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" readonly style="width: 150px;">
    </div>
</div>

    <input type="hidden" name="type_vehicule" value="{{ $typeVehicule }}">

    <h5 class="mb-2"><i class="bi bi-droplet-half"></i> Lavages sélectionnés :</h5>
    <ul class="list-group mb-3">
        @php $total = 0; @endphp
       @foreach ($lavagesChoisis as $lavage)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $lavage->type_lavage }}
        <span class="badge bg-success rounded-pill">{{ number_format($lavage->prix, 2) }} MAD</span>
    </li>
    <input type="hidden" name="lavages[]" value="{{ $lavage->id }}">
    <input type="hidden" name="type_lavage[]" value="{{ $lavage->type_lavage }}">
    <input type="hidden" name="prix[]" value="{{ $lavage->prix }}">
    @php $total += $lavage->prix; @endphp
@endforeach

    </ul>

    <div class="alert alert-info fs-5 text-center">
        <strong>Total :</strong> {{ number_format($total, 2) }} MAD
    </div>
</div>

        {{-- Marque --}}
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-car-front-fill me-1"></i> Marque du véhicule
            </label>
            <select name="marque" class="form-select">
                <option value="">-- Choisir une marque --</option>
                @foreach (['Renault','Peugeot','Citroën','Volkswagen','Dacia','Toyota','Hyundai','Ford','Mercedes','BMW','Fiat','Kia','Opel'] as $marque)
                    <option value="{{ $marque }}">{{ $marque }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="error-marque"></div>
        </div>

        {{-- Matricule --}}
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-123 me-1"></i> Matricule du véhicule
            </label>
            <input type="text" name="matricule" class="form-control" placeholder="Ex: 12345-A-6">
            <div class="invalid-feedback" id="error-matricule"></div>
        </div>

        {{-- Employé --}}
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-person-fill me-1"></i> Employé ayant effectué le lavage
            </label>
            <select name="employe_id" class="form-select">
                <option value="">-- Choisir un employé --</option>
                @foreach ($employes as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="error-employe_id"></div>
        </div>

        {{-- Remarque --}}
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-chat-left-dots me-1"></i> Remarque
            </label>
            <textarea name="remarque" class="form-control" rows="3" placeholder="Optionnel..."></textarea>
            <div class="invalid-feedback" id="error-remarque"></div>
        </div>

        {{-- Client Société --}}
        <div id="societeSection" style="display: none;">
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_societe" name="is_societe">
                <label class="form-check-label" for="is_societe">
                    <i class="bi bi-building"></i> Client société ?
                </label>
            </div>

            <div class="mb-3" id="societe_block" style="display: none;">
                <label class="form-label">
                    <i class="bi bi-building-fill"></i> Société
                </label>
                <select name="societe_id" class="form-select">
                    <option value="">-- Choisir une société --</option>
                    @foreach ($societes as $societe)
                        <option value="{{ $societe->id }}">{{ $societe->nom }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback" id="error-societe_id"></div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="button" class="btn btn-success btn-lg" onclick="submitForm(event)">
                <i class="bi bi-save2-fill me-2"></i> Enregistrer la prestation
            </button>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        ✅ Prestation enregistrée avec succès !
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>


    </form>
</div>

{{-- JS Société + Affichage dynamique --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const typeVehiculeInput = document.querySelector('input[name="type_vehicule"]');
    const typeVehiculeValue = typeVehiculeInput ? typeVehiculeInput.value.trim() : '';
    const societeSection = document.getElementById('societeSection');
    const isSocieteCheckbox = document.getElementById('is_societe');
    const societeBlock = document.getElementById('societe_block');

    if (typeVehiculeValue === 'voiture_de_service') {
        societeSection.style.display = 'block';
    } else {
        societeSection.style.display = 'none';
        if (isSocieteCheckbox) isSocieteCheckbox.checked = false;
        if (societeBlock) societeBlock.style.display = 'none';
    }

    if (isSocieteCheckbox) {
        isSocieteCheckbox.addEventListener('change', () => {
            societeBlock.style.display = isSocieteCheckbox.checked ? 'block' : 'none';
        });
    }
});
</script>

<script>
function clearErrors() {
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.form-control, .form-select').forEach(el => {
        el.classList.remove('is-invalid');
    });
}

async function submitForm(event) {
    event.preventDefault();
    clearErrors();

    const form = document.getElementById('prestationForm');
    const formData = new FormData(form);

    try {
        const response = await fetch("{{ route('prestations.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            if (data.errors) {
                for (const [field, messages] of Object.entries(data.errors)) {
                    const input = document.querySelector(`[name="${field}"]`);
                    const feedback = document.getElementById(`error-${field}`);
                    if (input && feedback) {
                        input.classList.add('is-invalid');
                        feedback.textContent = messages.join(' ');
                    }
                }
            } else {
                alert("Une erreur inattendue est survenue.");
                console.error(data);
            }
            return;
        }

       if (data.success && data.id) {
    // Masquer le bouton Enregistrer
    document.querySelector('button[onclick="submitForm(event)"]').style.display = 'none';

    // Afficher la box de confirmation
    const confirmationBox = document.getElementById('confirmationBox');
    confirmationBox.style.display = 'block';

    // Mettre à jour le lien du bouton Imprimer
    document.getElementById('btnImprimerTicket').href = `/prestations/${data.id}/ticket`;
}


    } catch (error) {
        console.error('Erreur AJAX :', error);
        alert("Erreur de communication avec le serveur.");
    }
}
</script>


@endsection

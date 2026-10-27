@component('mail::message')
# Bonjour {{ $reservation->nom }} 👋

✅ Votre réservation a bien été enregistrée !

**Détails de votre rendez-vous :**

- 📅 **Date** : {{ $reservation->date_reservation }}
- 🕑 **Heure** : {{ $reservation->heure_reservation }}
- 🚗 **Type de véhicule** : {{ ucfirst($reservation->type_vehicule) }}
- 🧽 **Type de lavage** : {{ ucfirst($reservation->type_lavage) }}
- 📧 **Email** : {{ $reservation->email }}
- 📞 **Téléphone** : {{ $reservation->telephone }}

@if($reservation->remarque)
- ✏️ **Remarque** : {{ $reservation->remarque }}
@endif

---

@component('mail::button', ['url' => url('/')])
Voir notre site
@endcomponent

Merci pour votre confiance 🙏
L'équipe **Votre Entreprise**
@endcomponent
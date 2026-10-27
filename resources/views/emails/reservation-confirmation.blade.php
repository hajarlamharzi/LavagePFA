<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation</title>
</head>
<body>
    <h2>Bonjour {{ $reservation->nom }},</h2>

    <p>Merci pour votre réservation chez <strong>Notre Service de Lavage</strong>.</p>

    <p>
        <strong>Détails de votre RDV :</strong><br>
        Date : {{ $reservation->date_reservation }}<br>
        Heure : {{ $reservation->heure_reservation }}<br>
        Véhicule : {{ ucfirst($reservation->type_vehicule) }}<br>
        Services :
        @php $services = json_decode($reservation->services, true); @endphp
        <ul>
            @foreach ($services as $s)
                <li>{{ ucfirst($s['type_lavage']) }}</li>
            @endforeach
        </ul>
    </p>

    <p>Nous vous attendons avec plaisir !</p>

    <p>Cordialement,<br>L'équipe</p>
</body>
</html>

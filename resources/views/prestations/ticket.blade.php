
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket Prestation</title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: white;
        }

        .ticket {
            width: 80mm;
            padding: 5mm;
            font-size: 12px;
        }

        .ticket img {
            display: block;
            margin: 0 auto 10px auto;
            width: 80px;
        }

        .ticket h2 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .line {
            font-size: 12px;
            margin: 4px 0;
        }

        .qrcode {
            text-align: center;
            margin-top: 10px;
        }

        .no-print {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
.ticket ul {
    padding-left: 15px;
    margin: 5px 0;
}

.ticket li {
    font-size: 12px;
    margin-bottom: 2px;
}

        @media print {
            .no-print {
                display: none !important;
            }

            html, body {
                width: 80mm;
                height: auto;
                margin: 0;
                padding: 0;
            }

            .ticket {
                margin: 0;
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
 <div class="ticket">
    <img src="{{ asset('images/logo.jpeg') }}" alt="Green Car Logo">
    <h2>Ticket de Prestation</h2>

    <div class="line">N° : <strong>{{ $prestation->id }}</strong></div>
    <div class="line">Date : <strong>{{ $prestation->date_prestation }}</strong></div>
    <div class="line">Véhicule : <strong>{{ $prestation->marque }} ({{ $prestation->matricule }})</strong></div>

 @php
$lavages = is_array(json_decode($prestation->type_lavage, true))
           ? json_decode($prestation->type_lavage, true)
           : [['type_lavage' => $prestation->type_lavage, 'prix' => $prestation->prix]];
@endphp


    <div class="line"><strong>Détails des lavages :</strong></div>
    <ul>
        @foreach ($lavages as $lavage)
            <li>{{ $lavage['type_lavage'] }} - {{ number_format($lavage['prix'], 2) }} MAD</li>
        @endforeach
    </ul>

    <div class="line"><strong>Total : {{ number_format($prestation->prix, 2) }} MAD</strong></div>

    <div class="line">Employé : <strong>{{ $prestation->employe->prenom }} {{ $prestation->employe->nom }}</strong></div>

    @if($prestation->societe)
        <div class="line">Société : <strong>{{ $prestation->societe->nom }}</strong></div>
    @endif

    @if($prestation->remarque)
        <div class="line">Remarque : <em>{{ $prestation->remarque }}</em></div>
    @endif



    <div class="qrcode">
        {!! QrCode::size(100)->generate('https://g.co/kgs/qpFjZje') !!}
        <p style="font-size: 14px; font-weight: bold; text-align: center; margin-top: 8px;">
            ⭐ Donnez-nous votre avis sur Google !
        </p>
    </div>
</div>
<div class="no-print">
    <button onclick="printAndRedirect()" style="padding: 8px 16px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">
        <i class="bi bi-printer"></i> Imprimer et Retourner
    </button>
    <a href="/vehicules" style="margin-left: 10px; padding: 8px 16px; background-color: #34495e; color: white; text-decoration: none; border-radius: 4px;">
        <i class="bi bi-arrow-left"></i> Retourner
    </a>
</div>


    <script>
        function printAndRedirect() {
            window.print();
            setTimeout(function () {
                window.location.href = "/vehicules";
            }, 1000);
        }

    </script>
</body>
</html>

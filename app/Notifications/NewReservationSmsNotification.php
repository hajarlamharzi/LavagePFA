<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;

class NewReservationSmsNotification extends Notification
{
    use Queueable;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        // Simule l'envoi SMS
        Log::info("SMS à {$this->reservation->telephone}: Votre réservation est confirmée pour le {$this->reservation->date_reservation} à {$this->reservation->heure_reservation}.");

        return [
            'message' => "SMS envoyé à {$this->reservation->telephone} pour réservation le {$this->reservation->date_reservation} à {$this->reservation->heure_reservation}."
        ];
    }
}

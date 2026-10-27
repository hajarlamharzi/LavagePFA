<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Nouvelle réservation de {$this->reservation->nom} le {$this->reservation->date_reservation} à {$this->reservation->heure_reservation}",
            'reservation_id' => $this->reservation->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle réservation reçue')
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Une nouvelle réservation a été effectuée par : {$this->reservation->nom}")
            ->line("Téléphone : {$this->reservation->telephone}")
            ->line("Date : {$this->reservation->date_reservation}")
            ->line("Heure : {$this->reservation->heure_reservation}")
            ->action('Voir les réservations', url('/admin/reservations'))
            ->line('Merci pour votre travail !');
    }
}

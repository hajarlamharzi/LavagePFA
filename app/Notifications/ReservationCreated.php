<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCreated extends Notification
{
    use Queueable;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database']; // ajoute 'mail' si tu veux envoyer un email
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Nouvelle réservation de {$this->reservation->nom} pour le {$this->reservation->date_reservation} à {$this->reservation->heure_reservation}.",
            'reservation_id' => $this->reservation->id,
        ];
    }

    // optionnel : email
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle Réservation Client')
            ->line('Une nouvelle réservation a été effectuée.')
            ->line("Client : {$this->reservation->nom}")
            ->line("Date : {$this->reservation->date_reservation}")
            ->line("Heure : {$this->reservation->heure_reservation}")
            ->action('Voir les réservations', url('/admin/reservations'))
            ->line('Merci de votre confiance.');
    }
}

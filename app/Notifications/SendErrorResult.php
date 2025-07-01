<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendErrorResult extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(private string $message)
    {
    }

    /**
     * Canaux de diffusion de la notification.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Représentation de la notification pour le mail.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Échec de la publication des résultats')
            ->line('Une erreur est survenue lors de la tentative de publication des résultats.')
            ->line('Détail de l’erreur :')
            ->line($this->message)
            ->line('Veuillez corriger le problème et réessayer.')
            ->salutation('Cordialement, L\'équipe technique');
    }

    /**
     * Représentation de la notification pour la base de données.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Erreur de publication des résultats',
            'description' => $this->message,
        ];
    }
}

<?php

namespace App\Notifications;

use App\Helpers\SignedUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Crée une nouvelle notification.
     */
    public function __construct()
    {
        // Paramètres possibles si nécessaire plus tard
    }

    /**
     * Canaux utilisés pour envoyer la notification.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Contenu de l’e-mail envoyé à l’utilisateur.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = SignedUrl::generateVerificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Vérification de votre adresse e-mail')
            ->greeting('Bonjour ' . ($notifiable->name ?? ''))
            ->line("Vous recevez ce message parce que vous avez demandé la vérification de votre adresse e-mail.")
            ->action('Vérifier mon adresse e-mail', $url)
            ->line("Si vous n'avez pas fait cette demande, vous pouvez ignorer ce message.")
            ->salutation('Cordialement, L’équipe de Polytechnic');
    }

    /**
     * Données enregistrées si la notification est stockée en base.
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}

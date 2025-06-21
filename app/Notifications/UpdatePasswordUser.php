<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdatePasswordUser extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre mot de passe a été mis à jour')
            ->line('Bonjour ' . $notifiable->name . ',')
            ->line('Votre mot de passe a bien été modifié. Si vous n’êtes pas à l’origine de ce changement, veuillez contacter immédiatement le support.')
            ->action('Accéder à votre compte', $this->getRouteProfile())
            ->line('Merci d’utiliser notre application.');
    }

    /**
     * Get the array representation of the notification (for database).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Mot de passe mis à jour',
            'description' => 'Votre mot de passe a été changé avec succès.',
            'url' => $this->getRouteProfile(),
        ];
    }

    private function getRouteProfile(): string
    {
        return config('app.frontend_url') . '/profile';
    }
}

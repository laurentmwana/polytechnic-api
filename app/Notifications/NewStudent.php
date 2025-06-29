<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewStudent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $defaultPassword = "12345678") {}

    /**
     * Les canaux de diffusion.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Notification envoyée par email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl =  config('app.frontend_url') . '/auth/login';

        return (new MailMessage)
            ->subject('🎓 Votre compte étudiant a été créé')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line("Bienvenue sur la plateforme de la faculté de polytechnique.")
            ->line("Votre compte étudiant a été créé avec succès. Voici vos informations :")
            ->line("**Matricule :** " . $notifiable->student->registration_token)
            ->line("**Adresse email :** " . $notifiable->email)
            ->line("**Mot de passe par défaut :** " . $this->defaultPassword)
            ->line("Nous vous recommandons de changer ce mot de passe après votre première connexion.")
            ->action('Se connecter', $loginUrl);
    }

    /**
     * Notification enregistrée dans la base de données.
     */
    public function toArray(object $notifiable): array
    {
        $profileUrl =  config('app.frontend_url') . '/profile';

        return [
            'title' => 'Votre compte étudiant a été créé',
            'description' => 'Bienvenue ' . $notifiable->name . ', votre compte étudiant a bien été activé. Votre matricule est : ' . $notifiable->student->registration_token,
            'url' => $profileUrl,
        ];
    }
}

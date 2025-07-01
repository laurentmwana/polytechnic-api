<?php

namespace App\Notifications;

use App\Models\Result;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResultAvailable extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Result $result)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {

        $name = $this->getStudentName();

        return (new MailMessage)
            ->subject('Résultats disponibles')
            ->greeting("Bonjour {$name},")
            ->line('Vos résultats pour la session actuelle sont maintenant disponibles.')
            ->action('Voir mes résultats', $this->getResultUrl())
            ->line('Merci de votre confiance et bonne continuation !');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $name = $this->getStudentName();

        return [
            'title' => "Résultats disponibles.",
            'description' => "{$name}, vos résultats pour la session actuelle sont maintenant disponibles.",
            'url' => $this->getResultUrl(),
        ];
    }

    private function getResultUrl()
    {
        $id = $this->result->id;

        return config('app.frontend_url') . "/result#{$id}";
    }

    private function getStudentName()
    {
        return $this->result->student->name ." ". $this->result->student->firstname;
    }

}

<?php

namespace App\Notifications;

use App\Models\Actuality;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewActuality extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Actuality $actuality)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle actualité publiée')
            ->line("Une nouvelle actualité a été publiée.")
            ->line("Titre : {$this->actuality->title}")
            ->action('Lire l\'actualité', $this->getRouteShowUrl())
            ->line('Merci de rester informé(e) avec nous !');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Nouvelle actualité',
            'description' => "Une nouvelle actualité \"{$this->actuality->title}\" a été publiée.",
            'url' => $this->getRouteShowUrl(),
        ];
    }

    private function getRouteShowUrl()
    {
        return config('app.frontend_url') . '/actuality/' . $this->actuality->id;
    }
}

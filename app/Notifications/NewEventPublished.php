<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEventPublished extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Event $event, private Student $student)
    {
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
            ->subject('🗓️ Nouvel événement : ' . $this->event->title)
            ->greeting('Bonjour ' . $notifiable->name . ' 👋')
            ->line('Un nouvel événement a été publié :')
            ->line('📌 ' . $this->event->title)
            ->line('🕒 Début : ' . $this->event->start_at)
            ->line('📄 Description : ' . $this->event->description)
            ->action('Voir l’événement', $this->getEventShowRoute())
            ->line('Merci de rester connecté à la plateforme.');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'title' => $this->event->title,
            'description' => $this->event->description,
            'start_at' => $this->event->start_at,
            'url' => $this->getEventShowRoute(),
        ];
    }

    private function getEventShowRoute(): string
    {
        return config('app.frontend_url') . "/event/{$this->event->id}";
    }

}

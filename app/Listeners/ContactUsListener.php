<?php

namespace App\Listeners;

use App\Mail\ContactUsMail;
use App\Events\ContactUsEvent;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private Mailer $mailer)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(ContactUsEvent $event): void
    {
        $this->mailer->send(new ContactUsMail($event->data));
    }
}

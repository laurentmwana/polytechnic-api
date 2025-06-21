<?php

namespace App\Listeners;

use App\Events\AdminResultsEvent;
use App\Mail\NotifyAdminResultsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;

class AdminResultsListener implements ShouldQueue
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
    public function handle(AdminResultsEvent $event): void
    {
        $this->mailer->send(new NotifyAdminResultsMail($event->deliberation, $event->user));
    }
}

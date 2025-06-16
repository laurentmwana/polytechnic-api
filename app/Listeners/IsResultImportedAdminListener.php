<?php

namespace App\Listeners;

use App\Events\IsResultImportedEvent;
use App\Mail\ResultImportedAdminMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class IsResultImportedAdminListener
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
    public function handle(IsResultImportedEvent $event): void
    {
        $this->mailer->send(new ResultImportedAdminMail($event->deliberation, $event->user));
    }
}

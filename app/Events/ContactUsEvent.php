<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ContactUsEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public array $data) {}
}

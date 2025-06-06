<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class ContactUsEvent implements ShouldQueue
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public array $data) {}
}

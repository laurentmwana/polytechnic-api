<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Event;
use App\Notifications\NewEventPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NewEventJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Event $event)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         $students = Student::with('user')
        ->whereHas('actual_levels', function ($query) {
            $query->where('level_id', $this->event->level_id);
        })
        ->get();

        foreach ($students as $student) {
            if ($student->user) {
                $student->user->notify(new NewEventPublished($this->event, $student));
            }
        }
    }
}

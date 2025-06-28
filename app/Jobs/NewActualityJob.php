<?php

namespace App\Jobs;

use App\Enums\RoleUserEnum;
use App\Models\Actuality;
use App\Models\User;
use App\Notifications\NewActuality;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NewActualityJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Actuality $actuality, private User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users  = User::where('id', '!=', $this->user->id)
            ->where(function ($builder) {
                $builder->where('roles', 'like', '%' . RoleUserEnum::STUDENT->value . '%')
                    ->orWhere('roles', 'like', '%' . RoleUserEnum::DISABLE->value . '%');
            })
            ->get();

        foreach ($users as $user) {
            $user->notify(new NewActuality($this->actuality));
        }
    }
}

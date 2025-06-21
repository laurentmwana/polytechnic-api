<?php

namespace App\Console\Commands;

use App\Enums\RoleUserEnum;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPasswordUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-password-user-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset password for all user admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('roles', 'like', '%' . RoleUserEnum::ADMIN->value . '%')
            ->get();

        foreach ($users as $user) {
            $user->update([
                'password' => Hash::make('ge12345678')
            ]);
        }

    }
}

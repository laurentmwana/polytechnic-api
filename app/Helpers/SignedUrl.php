<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\URL;

abstract class SignedUrl
{
    public static function getVerifyUrl(User $user): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
    }
}

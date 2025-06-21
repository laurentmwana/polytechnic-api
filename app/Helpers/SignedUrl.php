<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\URL;

abstract class SignedUrl
{

    public static function generateVerificationUrl(User $user): string
    {
        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id'   => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $backendBase = rtrim(config('app.url'), '/') . '/api';
        $path = str_replace($backendBase, '', $signedUrl); // ex. /verify-email/20/hash?...

        $frontendPath = '/auth/' . ltrim($path, '/');

        return rtrim(config('app.frontend_url'), '/') . $frontendPath;
    }
}

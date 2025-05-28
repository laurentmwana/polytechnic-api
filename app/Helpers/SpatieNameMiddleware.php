<?php

namespace App\Helpers;

use App\Enums\UserRoleEnum;

abstract  class SpatieNameMiddleware
{
    public static function admin(): string
    {
        return sprintf("role:%s", UserRoleEnum::ADMIN->value);
    }

    public static function student(): string
    {
        return sprintf("role:%s", UserRoleEnum::STUDENT->value);
    }

    public static function anonymous(): string
    {
        return sprintf("role:%s", UserRoleEnum::DEFAULT->value);
    }
}

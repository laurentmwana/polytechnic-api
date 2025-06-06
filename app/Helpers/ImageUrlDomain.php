<?php

namespace App\Helpers;

abstract class ImageUrlDomain
{
    public static function parse(string $path): string
    {
        return sprintf(
            "%s/storage/%s",
            config('app.url'),
            $path
        );
    }
}

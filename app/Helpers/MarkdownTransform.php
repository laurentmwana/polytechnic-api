<?php

namespace App\Helpers;

use Illuminate\Support\Str;

abstract class MarkdownTransform
{
    public static function transform(string $markdown): string
    {
        return Str::markdown($markdown, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }
}

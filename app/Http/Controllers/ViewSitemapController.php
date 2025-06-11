<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ViewSitemapController
{
    public function __invoke(#[Storage('local')] Filesystem $disk): BinaryFileResponse
    {
        abort_unless($disk->exists('sitemap.xml'), 404);

        return response()->file($disk->path('sitemap.xml'), [
            'Content-Type' => 'text/xml',
        ]);
    }
}

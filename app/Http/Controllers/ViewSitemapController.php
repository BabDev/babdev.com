<?php

namespace BabDev\Http\Controllers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ViewSitemapController
{
    public function __invoke(FilesystemManager $filesystem): BinaryFileResponse
    {
        /** @var FilesystemAdapter $disk */
        $disk = $filesystem->disk('local');

        abort_unless($disk->has('sitemap.xml'), 404);

        return response()->file($disk->path('sitemap.xml'), [
            'Content-Type' => 'text/xml',
        ]);
    }
}

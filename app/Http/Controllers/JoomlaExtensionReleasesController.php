<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\JoomlaExtension;
use BabDev\Models\JoomlaExtensionRelease;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class JoomlaExtensionReleasesController
{
    public function index(JoomlaExtension $joomlaExtension): Response
    {
        /** @var Collection|JoomlaExtensionRelease[] $extensions */
        $releases = $joomlaExtension->releases()
            ->ordered('desc')
            ->published()
            ->get();

        return response()->view(
            'extensions.releases.index',
            [
                'extension' => $joomlaExtension,
                'releases'  => $releases,
            ]
        );
    }
}

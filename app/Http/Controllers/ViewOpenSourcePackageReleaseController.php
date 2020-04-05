<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ViewOpenSourcePackageReleaseController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Package $package, string $packageRelease): Response
    {
        /** @var PackageRelease $release */
        $release = $package->releases()->where('slug', '=', $packageRelease)->firstOrFail();

        return $this->responseFactory->view(
            'open_source.package_release',
            [
                'package' => $package,
                'release' => $release,
                'media'   => $release->getMedia('downloads'),
            ]
        );
    }
}

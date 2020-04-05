<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class ViewOpenSourcePackageReleasesController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Package $package): Response
    {
        /** @var Collection|PackageRelease[] $extensions */
        $releases = $package->releases()
            ->visible()
            ->ordered('desc')
            ->get();

        return $this->responseFactory->view(
            'open_source.package_releases',
            [
                'package' => $package,
                'releases' => $releases,
            ]
        );
    }
}

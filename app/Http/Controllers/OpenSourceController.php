<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class OpenSourceController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function packages(): Response
    {
        /** @var Collection|Package[] $packages */
        $packages = Package::query()
            ->visible()
            ->orderBy('display_name')
            ->get();

        return $this->responseFactory->view(
            'open_source.packages',
            [
                'packages' => $packages,
            ]
        );
    }

    public function packageReleases(Package $package): Response
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

    public function packageRelease(Package $package, string $packageRelease): Response
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

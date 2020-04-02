<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OpenSourceController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function downloadReleaseFile(Request $request, int $media, Repository $config): StreamedResponse
    {
        $mediaClass = $config->get('media-library.media_model');

        /** @var Builder $query */
        $query = $mediaClass::query();

        /** @var Media $mediaModel */
        $mediaModel = $query->findOrFail($media);

        // Increment the download counter
        $downloads = $mediaModel->getCustomProperty('downloads', 0);
        $downloads++;

        $mediaModel->setCustomProperty('downloads', $downloads);
        $mediaModel->save();

        // Traverse up to the package and increment its counter too
        /** @var PackageRelease $release */
        $release = $mediaModel->model;

        /** @var Package $package */
        $package = $release->package;
        $package->downloads++;

        $package->save();

        return $mediaModel->toResponse($request);
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

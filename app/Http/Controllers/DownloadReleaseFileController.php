<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadReleaseFileController
{
    private ResponseFactory $responseFactory;
    private Repository $config;

    public function __construct(ResponseFactory $responseFactory, Repository $config)
    {
        $this->responseFactory = $responseFactory;
        $this->config = $config;
    }

    public function __invoke(Request $request, string $fileName): StreamedResponse
    {
        $mediaClass = $this->config->get('media-library.media_model');

        /** @var Builder $query */
        $query = $mediaClass::query();

        /** @var Media $media */
        $media = $query->where('file_name', '=', $fileName)->firstOrFail();

        // Increment the download counter
        $downloads = $media->getCustomProperty('downloads', 0);
        $downloads++;

        $media->setCustomProperty('downloads', $downloads);
        $media->save();

        // Traverse up to the package and increment its counter too
        /** @var PackageRelease $release */
        $release = $media->model;

        /** @var Package $package */
        $package = $release->package;
        $package->downloads++;

        $package->save();

        return $media->toResponse($request);
    }
}

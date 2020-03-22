<?php

namespace BabDev\NovaMediaLibrary\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadMediaController
{
    public function __invoke(int $media)
    {
        $mediaClass = config('media-library.media_model');

        /** @var Builder $query */
        $query = $mediaClass::query();

        /** @var Media $mediaModel */
        $mediaModel = $query->findOrFail($media);

        return $mediaModel;
    }
}

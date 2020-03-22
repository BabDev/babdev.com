<?php

namespace BabDev\NovaMediaLibrary\Concerns;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HandlesUrlConversions
{
    protected function getConversionUrls(Media $media): array
    {
        return [
            '__original__' => $media->getFullUrl(),
        ];
    }
}

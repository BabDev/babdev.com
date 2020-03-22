<?php

namespace BabDev\NovaMediaLibrary\Fields;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Field;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

abstract class MediaLibrary extends Field
{
    public $component = 'media-library-field';

    public $showOnIndex = false;

    public function multiple()
    {
        return $this->withMeta(['multiple' => true]);
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param HasMedia $resource
     * @param string $attribute
     *
     * @return Collection
     */
    protected function resolveAttribute($resource, $attribute)
    {
        return $resource->getMedia($attribute)
            ->map(
                function (Media $media) {
                    return array_merge(
                        $media->toArray(),
                        ['__media_urls__' => $this->getConversionUrls($media)]
                    );
                }
            );
    }

    protected function getConversionUrls(Media $media): array
    {
        return [
            '__original__' => $media->getFullUrl(),
        ];
    }
}

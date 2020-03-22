<?php

namespace BabDev\NovaMediaLibrary\Fields;

use BabDev\NovaMediaLibrary\Concerns\HandlesUrlConversions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Filesystem;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\TemporaryDirectory;

abstract class MediaLibrary extends Field
{
    use HandlesUrlConversions;

    public $component = 'media-library-field';

    public $showOnIndex = false;

    public function multiple()
    {
        return $this->withMeta(['multiple' => true]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param NovaRequest $request
     * @param string      $requestAttribute
     * @param HasMedia    $model
     * @param string      $attribute
     *
     * @return mixed
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $data = $request['__media__.' . $requestAttribute] ?? [];

        if ($attribute === 'ComputedField') {
            $attribute = \call_user_func($this->computedCallback, $model);
        }

        $this->handleMedia($request, $model, $attribute, $data);
    }

    /**
     * Handles synchronizing the media with its model.
     *
     * @param NovaRequest                  $request
     * @param HasMedia                     $model
     * @param string                       $attribute
     * @param array<int, int|UploadedFile> $data
     *
     * @return void
     */
    protected function handleMedia(NovaRequest $request, HasMedia $model, $attribute, $data): void
    {
        $remainingIds = $this->removeDeletedMedia($data, $model->getMedia($attribute));

        $newIds = $this->addNewMedia($request, $data, $model, $attribute);

        $existingIds = $this->addExistingMedia($request, $data, $model, $attribute, $model->getMedia($attribute));

        $this->setOrder($remainingIds->union($newIds)->union($existingIds)->sortKeys()->all());
    }

    /**
     * Handles removing any media dissociated from a model
     *
     * @param array<int, int|UploadedFile> $data
     * @param Collection|Media[]           $mediaCollection
     *
     * @return Collection|int[]
     */
    private function removeDeletedMedia($data, Collection $mediaCollection): Collection
    {
        $remainingIds = (new Collection($data))
            ->filter(
                static function ($value) {
                    return !$value instanceof UploadedFile;
                }
            );

        $mediaCollection->pluck('id')
            ->diff($remainingIds)
            ->each(
                static function ($id) use ($mediaCollection) {
                    /** @var Media $media */
                    if ($media = $mediaCollection->firstWhere('id', '=', $id)) {
                        $media->delete();
                    }
                }
            );

        return $remainingIds->intersect($mediaCollection->pluck('id'));
    }

    /**
     * Handles adding new media to a model
     *
     * @param NovaRequest                  $request
     * @param array<int, int|UploadedFile> $data
     * @param HasMedia                     $model
     * @param string                       $collection
     *
     * @return Collection|int[]
     */
    private function addNewMedia(NovaRequest $request, $data, HasMedia $model, string $collection): Collection
    {
        return (new Collection($data))
            ->filter(
                static function ($value) {
                    return $value instanceof UploadedFile;
                }
            )->map(
                function (UploadedFile $file, int $index) use ($request, $model, $collection) {
                    $media = $model->addMedia($file);

                    $media = $media->toMediaCollection($collection);

                    return $media->getKey();
                }
            );
    }

    /**
     * Handles ensuring existing media for a model is retained
     *
     * @param NovaRequest                  $request
     * @param array<int, int|UploadedFile> $data
     * @param HasMedia                     $model
     * @param string                       $collection
     * @param Collection|Media[]           $mediaCollection
     *
     * @return Collection|int[]
     */
    private function addExistingMedia(NovaRequest $request, $data, HasMedia $model, string $collection, Collection $mediaCollection): Collection
    {
        $addedMediaIds = $mediaCollection->pluck('id')->toArray();

        return (new Collection($data))
            ->filter(
                static function ($value) use ($addedMediaIds) {
                    return (!($value instanceof UploadedFile)) && !(\in_array((int) $value, $addedMediaIds));
                }
            )->map(
                static function ($mediaModelId, int $index) use ($request, $model, $collection) {
                    $mediaClass = config('media-library.media_model');

                    /** @var Media $existingMedia */
                    $existingMedia = $mediaClass::find($mediaModelId);

                    // Mimic copy behaviour of Spatie\MediaLibrary\MediaCollections\Models\Media::copy()
                    $temporaryDirectory = TemporaryDirectory::create();

                    $temporaryFile = $temporaryDirectory->path($existingMedia->file_name);

                    /** @var Filesystem $filesystem */
                    $filesystem = app(Filesystem::class);

                    $filesystem->copyFromMediaLibrary($existingMedia, $temporaryFile);

                    $media = $model->addMedia($temporaryFile);

                    $media = $media->toMediaCollection($collection);

                    // Delete our temp collection
                    $temporaryDirectory->delete();

                    return $media->getKey();
                }
            );
    }

    /**
     * Sets the order for media on a model
     *
     * @param int[] $ids
     *
     * @return void
     */
    private function setOrder(array $ids): void
    {
        $mediaClass = config('media-library.media_model');
        $mediaClass::setNewOrder($ids);
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param HasMedia $resource
     * @param string   $attribute
     *
     * @return Collection
     */
    protected function resolveAttribute($resource, $attribute)
    {
        return $resource->getMedia($attribute)
            ->map(
                function (Media $media) {
                    return \array_merge(
                        $media->toArray(),
                        ['__media_urls__' => $this->getConversionUrls($media)]
                    );
                }
            );
    }
}

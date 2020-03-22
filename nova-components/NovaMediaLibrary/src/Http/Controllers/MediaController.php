<?php

namespace BabDev\NovaMediaLibrary\Http\Controllers;

use BabDev\NovaMediaLibrary\Http\Requests\MediaRequest;
use BabDev\NovaMediaLibrary\Http\Resources\MediaResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(MediaRequest $request): JsonResource
    {
        $mediaClass = config('media-library.media_model');

        /** @var Builder $query */
        $query = $mediaClass::query();
        $query->where('collection_name', '=', $request->get('collection'));
        $query->orderBy('name');

        return MediaResource::collection($query->paginate($request->get('per_page', 18)));
    }
}

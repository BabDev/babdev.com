<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\PackageUpdate;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class ViewOpenSourceUpdatesController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(): Response
    {
        /** @var Collection|PackageUpdate[] $updates */
        $updates = PackageUpdate::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->paginate(10);

        return $this->responseFactory->view(
            'open_source.updates',
            [
                'updates' => $updates,
            ]
        );
    }
}

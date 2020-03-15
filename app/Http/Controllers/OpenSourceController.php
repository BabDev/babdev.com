<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
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
            ->orderBy('name')
            ->get();

        return $this->responseFactory->view(
            'open_source.packages',
            [
                'packages' => $packages,
            ]
        );
    }
}

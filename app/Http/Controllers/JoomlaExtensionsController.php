<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\JoomlaExtension;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class JoomlaExtensionsController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function index(): Response
    {
        /** @var Collection|JoomlaExtension[] $extensions */
        $extensions = JoomlaExtension::query()
            ->orderBy('name')
            ->get();

        return $this->responseFactory->view(
            'extensions.index',
            [
                'extensions' => $extensions,
            ]
        );
    }
}

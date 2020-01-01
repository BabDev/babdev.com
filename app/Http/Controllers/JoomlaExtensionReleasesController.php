<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\JoomlaExtension;
use BabDev\Models\JoomlaExtensionRelease;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class JoomlaExtensionReleasesController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function index(JoomlaExtension $joomlaExtension): Response
    {
        /** @var Collection|JoomlaExtensionRelease[] $extensions */
        $releases = $joomlaExtension->releases()
            ->ordered('desc')
            ->published()
            ->get();

        return $this->responseFactory->view(
            'extensions.releases.index',
            [
                'extension' => $joomlaExtension,
                'releases'  => $releases,
            ]
        );
    }

    public function show(JoomlaExtension $joomlaExtension, JoomlaExtensionRelease $joomlaExtensionRelease): Response
    {
        return $this->responseFactory->view(
            'extensions.releases.show',
            [
                'extension' => $joomlaExtension,
                'release'   => $joomlaExtensionRelease,
            ]
        );
    }
}

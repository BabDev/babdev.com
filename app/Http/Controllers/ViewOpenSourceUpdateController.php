<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\PackageUpdate;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ViewOpenSourceUpdateController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(PackageUpdate $update): Response
    {
        abort_unless($update->isPublished(), 404, 'Update Not Found');

        $update->load(
            [
                'package',
            ]
        );

        return $this->responseFactory->view(
            'open_source.updates.show',
            [
                'update' => $update,
            ]
        );
    }
}

<?php

namespace BabDev\Http\Controllers;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CKEditorUploadController
{
    private ResponseFactory $responseFactory;
    private Factory $filesystemFactory;

    public function __construct(ResponseFactory $responseFactory, Factory $filesystemFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->filesystemFactory = $filesystemFactory;
    }

    public function uploadImage(Request $request): JsonResponse
    {
        if (!$request->hasFile('upload')) {
            return $this->responseFactory->json(
                [
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'No file uploaded.',
                    ],
                ]
            );
        }

        $file = $request->file('upload');

        if (!$file->isValid()) {
            return $this->responseFactory->json(
                [
                    'uploaded' => 0,
                    'error' => [
                        'message' => sprintf(
                            'An error occurred while uploading the file: %s',
                            $file->getErrorMessage()
                        ),
                    ],
                ]
            );
        }

        /** @var FilesystemAdapter $disk */
        $disk = $this->filesystemFactory->disk('attachments');

        $file->storePubliclyAs('', $file->getClientOriginalName(), 'attachments');

        return $this->responseFactory->json(
            [
                'uploaded' => 1,
                'fileName' => $file->getClientOriginalName(),
                'url' => $disk->url($file->getClientOriginalName()),
            ]
        );
    }
}

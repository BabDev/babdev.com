<?php

namespace BabDev\Http\Controllers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UploadImageThruCKEditorController
{
    public function __invoke(Request $request, FilesystemManager $filesystem): JsonResponse
    {
        if (!$request->hasFile('upload')) {
            return response()->json(
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
            return response()->json(
                [
                    'uploaded' => 0,
                    'error' => [
                        'message' => \sprintf(
                            'An error occurred while uploading the file: %s',
                            $file->getErrorMessage()
                        ),
                    ],
                ]
            );
        }

        /** @var FilesystemAdapter $disk */
        $disk = $filesystem->disk('attachments');

        $file->storePubliclyAs('', $file->getClientOriginalName(), 'attachments');

        return response()->json(
            [
                'uploaded' => 1,
                'fileName' => $file->getClientOriginalName(),
                'url' => $disk->url($file->getClientOriginalName()),
            ]
        );
    }
}

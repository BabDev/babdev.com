<?php

namespace BabDev\Http\Controllers;

use BabDev\GitHub\RequestHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class HandleGitHubAppWebhookController
{
    public function __invoke(Request $request, RequestHandler $requestHandler): JsonResponse
    {
        $repoConfig = false;

        foreach (\array_keys(config('services.github.apps')) as $repo) {
            if (Str::is($repo, $request->input('repository.full_name'))) {
                $repoConfig = config("services.github.apps.$repo");

                break;
            }
        }

        abort_if($repoConfig === false, Response::HTTP_BAD_REQUEST, 'Unsupported repository.');

        if (isset($repoConfig['secret'])) {
            abort_unless($request->hasHeader('X-Hub-Signature'), Response::HTTP_FORBIDDEN, 'The request is not secured.');
            abort_unless($this->validSignature($request->header('X-Hub-Signature'), $repoConfig['secret'], $request->getContent()), Response::HTTP_FORBIDDEN, 'Invalid signature.');
        }

        $requestHandler->handleRequest($repoConfig, $request);

        return response()->json(['success' => true]);
    }

    private function validSignature(string $hash, string $key, string $data): bool
    {
        return \hash_equals($hash, 'sha1=' . \hash_hmac('sha1', $data, $key));
    }
}

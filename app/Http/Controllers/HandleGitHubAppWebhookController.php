<?php

namespace BabDev\Http\Controllers;

use BabDev\GitHub\RequestHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class HandleGitHubAppWebhookController
{
    public function __invoke(Request $request, RequestHandler $requestHandler): JsonResponse
    {
        $repoConfig = false;

        /** @var string $repo */
        foreach (array_keys(config('services.github.apps')) as $repo) {
            if (Str::is($repo, $request->input('repository.full_name'))) {
                $repoConfig = config("services.github.apps.$repo");

                break;
            }
        }

        abort_if($repoConfig === false, 400, 'Unsupported repository.');

        if (isset($repoConfig['secret'])) {
            abort_unless($request->hasHeader('X-Hub-Signature-256'), 403, 'The request is not secured.');
            abort_unless($this->hasValidSignature($request->header('X-Hub-Signature-256'), $repoConfig['secret'], $request->getContent()), 403, 'Invalid signature.');
        }

        $requestHandler->handleRequest($repoConfig, $request);

        return response()->json(['success' => true]);
    }

    private function hasValidSignature(string $hash, string $key, string $data): bool
    {
        return hash_equals($hash, 'sha256=' . hash_hmac('sha256', $data, $key));
    }
}

<?php

namespace App\Http\Controllers;

use App\Contracts\GitHub\Actions\Action;
use App\GitHub\Exceptions\BadRequestException;
use App\GitHub\RequestHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
final class HandleGitHubAppWebhookController
{
    public function __invoke(Request $request, RequestHandler $requestHandler): JsonResponse
    {
        try {
            /** @var string $repo */
            $repo = collect(config()->array('services.github.apps', []))
                ->keys()
                ->firstOrFail(static fn(string $configRepo): bool => Str::is($configRepo, $request->string('repository.full_name')->value()));
        } catch (ItemNotFoundException $exception) {
            throw new BadRequestHttpException('Unsupported repository.', $exception);
        }

        /** @phpstan-var GitHubRepoConfig $repoConfig */
        $repoConfig = config()->array("services.github.apps.$repo");

        abort_unless($request->hasHeader('X-Hub-Signature-256'), 403, 'The request is not secured.');

        $signature = $request->header('X-Hub-Signature-256');

        abort_if($signature === null, 403, 'Invalid signature.');

        abort_unless($this->hasValidSignature($signature, $repoConfig['secret'], $request->getContent()), 403, 'Invalid signature.');

        try {
            $requestHandler->handleRequest($repoConfig, $request);
        } catch (BadRequestException $exception) {
            throw new BadRequestHttpException('Invalid request.', $exception);
        }

        return response()->json(['success' => true]);
    }

    private function hasValidSignature(string $hash, string $key, string $data): bool
    {
        return hash_equals($hash, 'sha256=' . hash_hmac('sha256', $data, $key));
    }
}

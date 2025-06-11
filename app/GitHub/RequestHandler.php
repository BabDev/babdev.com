<?php

namespace App\GitHub;

use App\Contracts\GitHub\Actions\Action;
use App\Contracts\GitHub\Actions\Factory;
use App\Contracts\GitHub\ClientFactory;
use App\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use App\GitHub\Exceptions\BadRequestException;
use Github\AuthMethod;
use Github\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * @note Don't make readonly until Mockery supports readonly classes
 * @phpstan-import-type GitHubRepoConfig from Action
 */
class RequestHandler
{
    public function __construct(
        private readonly Factory $actionFactory,
        private readonly ClientFactory $clientFactory,
        private readonly JWTTokenGeneratorContract $tokenGenerator,
    ) {}

    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     *
     * @throws BadRequestException if the request data is invalid
     */
    public function handleRequest(#[\SensitiveParameter] array $repoConfig, Request $request): void
    {
        $event = $request->header('X-Github-Event');

        if ($event === null) {
            return;
        }

        if (!Arr::has($repoConfig, "events.$event")) {
            return;
        }

        $github = $this->buildClient($repoConfig, $request);

        /** @var class-string<Action> $actionClass */
        foreach (Arr::array($repoConfig, "events.$event") as $actionClass) {
            $action = $this->actionFactory->make($actionClass);
            $action($repoConfig, $request, $github);
        }
    }

    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     *
     * @throws BadRequestException if the request data is invalid
     */
    private function buildClient(#[\SensitiveParameter] array $repoConfig, Request $request): Client
    {
        throw_if($request->missing('installation.id'), BadRequestException::class, 'Missing required installation ID.');

        return tap(
            $this->clientFactory->make(apiVersion: 'machine-man-preview'),
            function (Client $client) use ($repoConfig, $request): void {
                $client->authenticate(
                    tokenOrLogin: $this->tokenGenerator->generate($repoConfig),
                    authMethod: AuthMethod::JWT,
                );

                $client->authenticate(
                    tokenOrLogin: Arr::string($client->apps()->createInstallationToken($request->integer('installation.id')), 'token'),
                    authMethod: AuthMethod::ACCESS_TOKEN,
                );
            },
        );
    }
}

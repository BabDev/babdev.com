<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\Actions\Factory;
use BabDev\Contracts\GitHub\ClientFactory;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use BabDev\GitHub\Exceptions\BadRequestException;
use Github\AuthMethod;
use Github\Client;
use Illuminate\Http\Request;

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

        throw_if(\is_array($event), BadRequestException::class, 'Invalid "X-Github-Event" header.');

        if ($event === null) {
            return;
        }

        if (!\array_key_exists($event, $repoConfig['events'])) {
            return;
        }

        $github = $this->buildClient($repoConfig, $request);

        /** @var class-string<Action> $actionClass */
        foreach ($repoConfig['events'][$event] as $actionClass) {
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

        $github = $this->clientFactory->make(apiVersion: 'machine-man-preview');

        $github->authenticate(tokenOrLogin: $this->tokenGenerator->generate($repoConfig), authMethod: AuthMethod::JWT);

        $token = $github->apps()->createInstallationToken($request->input('installation.id'));

        $github->authenticate(tokenOrLogin: $token['token'], authMethod: AuthMethod::ACCESS_TOKEN);

        return $github;
    }
}

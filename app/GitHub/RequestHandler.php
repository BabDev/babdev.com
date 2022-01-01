<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\Actions\Factory;
use BabDev\Contracts\GitHub\ClientFactory;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use Github\AuthMethod;
use Github\Client;
use Illuminate\Http\Request;

class RequestHandler
{
    public function __construct(
        private Factory $actionFactory,
        private ClientFactory $clientFactory,
        private JWTTokenGeneratorContract $tokenGenerator,
    ) {
    }

    public function handleRequest(array $repoConfig, Request $request): void
    {
        $event = $request->header('X-Github-Event');

        if (empty($repoConfig['events'][$event])) {
            return;
        }

        $github = $this->buildClient($repoConfig, $request);

        /** @var class-string<Action> $actionClass */
        foreach ($repoConfig['events'][$event] as $actionClass) {
            $action = $this->actionFactory->make($actionClass);
            $action($repoConfig, $request, $github);
        }
    }

    private function buildClient(array $repoConfig, Request $request): Client
    {
        $github = $this->clientFactory->make(null, 'machine-man-preview');

        $github->authenticate($this->tokenGenerator->generate($repoConfig), null, AuthMethod::JWT);

        $token = $github->apps()->createInstallationToken($request->input('installation.id'));

        $github->authenticate($token['token'], null, AuthMethod::ACCESS_TOKEN);

        return $github;
    }
}

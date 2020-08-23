<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Factory;
use Github\Client;
use Github\HttpClient\Builder as GithubHttpBuilder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder as JWTBuilder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class RequestHandler
{
    private Dispatcher $dispatcher;
    private GithubHttpBuilder $githubHttpBuilder;
    private Factory $actionFactory;

    public function __construct(Dispatcher $dispatcher, GithubHttpBuilder $githubHttpBuilder, Factory $actionFactory)
    {
        $this->dispatcher = $dispatcher;
        $this->githubHttpBuilder = $githubHttpBuilder;
        $this->actionFactory = $actionFactory;
    }

    public function handleRequest(array $repoConfig, Request $request): void
    {
        $event = $request->header('X-Github-Event');

        if (empty($repoConfig['events'][$event])) {
            return;
        }

        $github = $this->buildClient($repoConfig, $request);

        /** @var class-string $actionClass */
        foreach ($repoConfig['events'][$event] as $actionClass) {
            $action = $this->actionFactory->make($actionClass);
            $action($repoConfig, $request, $github);
        }
    }

    private function buildClient(array $repoConfig, Request $request): Client
    {
        $github = new Client($this->githubHttpBuilder, 'machine-man-preview');

        $jwt = (new JWTBuilder())
            ->issuedBy($repoConfig['app_id'])
            ->issuedAt(\time())
            ->expiresAt(\time() + 60)
            ->getToken(new Sha256(), new Key(\sprintf('file://%s', $repoConfig['key'])));

        $github->authenticate($jwt, null, Client::AUTH_JWT);

        $token = $github->api('apps')->createInstallationToken($request->input('installation.id'));

        $github->authenticate($token['token'], null, Client::AUTH_ACCESS_TOKEN);

        return $github;
    }
}

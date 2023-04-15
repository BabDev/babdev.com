<?php

namespace Tests\Unit\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\Actions\Factory;
use BabDev\Contracts\GitHub\ClientFactory;
use BabDev\Contracts\GitHub\JWTTokenGenerator;
use BabDev\GitHub\Exceptions\BadRequestException;
use BabDev\GitHub\RequestHandler;
use Github\Api\Apps;
use Github\AuthMethod;
use Github\Client;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class RequestHandlerTest extends TestCase
{
    private MockObject&Factory $actionFactory;

    private MockObject&ClientFactory $clientFactory;

    private MockObject&JWTTokenGenerator $tokenGenerator;

    private RequestHandler $handler;

    protected function setUp(): void
    {
        $this->actionFactory = $this->createMock(Factory::class);
        $this->clientFactory = $this->createMock(ClientFactory::class);
        $this->tokenGenerator = $this->createMock(JWTTokenGenerator::class);

        $this->handler = new RequestHandler($this->actionFactory, $this->clientFactory, $this->tokenGenerator);
    }

    public function test_the_handler_only_acts_on_supported_events(): void
    {
        $repoConfig = [
            'app_id' => '12345',
            'key' => 'key',
            'secret' => 'secret',
            'events' => [],
        ];

        $request = Request::createFromBase(
            SymfonyRequest::create(
                '/webhooks/github/app',
                'POST',
            ),
        );
        $request->headers->set('X-Github-Event', 'pull_request');

        $this->clientFactory->expects($this->never())
            ->method('make');

        $this->handler->handleRequest($repoConfig, $request);
    }

    public function test_the_handler_acts_on_a_supported_event(): void
    {
        $repoConfig = [
            'app_id' => '12345',
            'key' => 'key',
            'secret' => 'secret',
            'events' => [
                'pull_request' => [
                    Action::class,
                ],
            ],
        ];

        $request = Request::createFromBase(
            SymfonyRequest::create(
                '/webhooks/github/app',
                'POST',
                [
                    'installation' => [
                        'id' => '123',
                    ],
                ],
            ),
        );
        $request->headers->set('X-Github-Event', 'pull_request');

        /** @var MockObject&Apps $apps */
        $apps = $this->createMock(Apps::class);
        $apps->expects($this->once())
            ->method('createInstallationToken')
            ->with('123')
            ->willReturn(['token' => 'access-token']);

        /** @var MockObject&Client $github */
        $github = $this->createMock(Client::class);
        $github->expects($this->exactly(2))
            ->method('authenticate')
            ->willReturnMap([
                ['jwt-token', null, AuthMethod::JWT, null],
                ['access-token', null, AuthMethod::ACCESS_TOKEN, null],
            ]);

        $github->expects($this->once())
            ->method('__call')
            ->with('apps')
            ->willReturn($apps);

        $this->clientFactory->expects($this->once())
            ->method('make')
            ->with(null, 'machine-man-preview')
            ->willReturn($github);

        $this->tokenGenerator->expects($this->once())
            ->method('generate')
            ->with($repoConfig)
            ->willReturn('jwt-token');

        $this->actionFactory->expects($this->once())
            ->method('make')
            ->willReturn($this->createMock(Action::class));

        $this->handler->handleRequest($repoConfig, $request);
    }

    public function test_the_handler_rejects_a_request_with_a_missing_installation_id(): void
    {
        $this->expectException(BadRequestException::class);

        $repoConfig = [
            'app_id' => '12345',
            'key' => 'key',
            'secret' => 'secret',
            'events' => [
                'pull_request' => [
                    Action::class,
                ],
            ],
        ];

        $request = Request::createFromBase(
            SymfonyRequest::create(
                '/webhooks/github/app',
                'POST',
            ),
        );
        $request->headers->set('X-Github-Event', 'pull_request');

        $this->clientFactory->expects($this->never())
            ->method('make');

        $this->handler->handleRequest($repoConfig, $request);
    }
}

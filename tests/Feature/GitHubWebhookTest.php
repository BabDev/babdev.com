<?php

namespace Tests\Feature;

use BabDev\GitHub\Exceptions\BadRequestException;
use BabDev\GitHub\RequestHandler;
use Illuminate\Contracts\Config\Repository;
use Mockery\MockInterface;
use Tests\TestCase;

class GitHubWebhookTest extends TestCase
{
    /** @test */
    public function an_app_webhook_for_an_unsupported_repository_results_in_a_400_response(): void
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        $config->set('services.github.apps', []);

        $this->json('POST', '/webhooks/github/app', ['repository' => ['full_name' => 'BabDev/unsupported']])
            ->assertStatus(400);
    }

    /** @test */
    public function an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_no_signature_header_results_in_a_403_response(): void
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        $config->set(
            'services.github.apps',
            [
                'BabDev/test-repo' => [
                    'app_id' => 'a1b2c3',
                    'key' => \dirname(__DIR__) . '/fixtures/private-key.pem',
                    'secret' => 'my-secret-value',
                    'events' => [],
                ],
            ],
        );

        $this->json('POST', '/webhooks/github/app', ['repository' => ['full_name' => 'BabDev/test-repo']])
            ->assertStatus(403);
    }

    /** @test */
    public function an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_an_invalid_signature_results_in_a_403_response(): void
    {
        $secret = 'my-secret-value';

        /** @var Repository $config */
        $config = $this->app->make('config');

        $config->set(
            'services.github.apps',
            [
                'BabDev/test-repo' => [
                    'app_id' => 'a1b2c3',
                    'key' => \dirname(__DIR__) . '/fixtures/private-key.pem',
                    'secret' => 'my-secret-value',
                    'events' => [],
                ],
            ],
        );

        $requestData = ['repository' => ['full_name' => 'BabDev/test-repo']];

        $signatureHeader = hash_hmac('sha256', 'bad-data', $secret);

        $this->json('POST', '/webhooks/github/app', $requestData, ['X-Hub-Signature-256' => 'sha256=' . $signatureHeader])
            ->assertStatus(403);
    }

    /** @test */
    public function an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_a_valid_signature_is_processed(): void
    {
        $this->instance(
            RequestHandler::class,
            \Mockery::mock(RequestHandler::class, function (MockInterface $mock): void {
                $mock->shouldReceive('handleRequest')->once();
            }),
        );

        $secret = 'my-secret-value';

        /** @var Repository $config */
        $config = $this->app->make('config');

        $config->set(
            'services.github.apps',
            [
                'BabDev/test-repo' => [
                    'app_id' => 'a1b2c3',
                    'key' => \dirname(__DIR__) . '/fixtures/private-key.pem',
                    'secret' => 'my-secret-value',
                    'events' => [],
                ],
            ],
        );

        $requestData = ['repository' => ['full_name' => 'BabDev/test-repo']];

        $signatureHeader = hash_hmac('sha256', json_encode($requestData, \JSON_THROW_ON_ERROR), $secret);

        $this->json('POST', '/webhooks/github/app', $requestData, ['X-Hub-Signature-256' => 'sha256=' . $signatureHeader])
            ->assertSuccessful();
    }

    /** @test */
    public function an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_a_valid_signature_is_not_processed_if_an_invalid_request_is_given(): void
    {
        $this->instance(
            RequestHandler::class,
            \Mockery::mock(RequestHandler::class, function (MockInterface $mock): void {
                $mock->shouldReceive('handleRequest')->andThrow(new BadRequestException('Invalid request'));
            }),
        );

        $secret = 'my-secret-value';

        /** @var Repository $config */
        $config = $this->app->make('config');

        $config->set(
            'services.github.apps',
            [
                'BabDev/test-repo' => [
                    'app_id' => 'a1b2c3',
                    'key' => \dirname(__DIR__) . '/fixtures/private-key.pem',
                    'secret' => 'my-secret-value',
                    'events' => [],
                ],
            ],
        );

        $requestData = ['repository' => ['full_name' => 'BabDev/test-repo']];

        $signatureHeader = hash_hmac('sha256', json_encode($requestData, \JSON_THROW_ON_ERROR), $secret);

        $this->json('POST', '/webhooks/github/app', $requestData, ['X-Hub-Signature-256' => 'sha256=' . $signatureHeader])
            ->assertStatus(400);
    }
}

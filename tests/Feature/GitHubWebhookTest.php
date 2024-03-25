<?php

namespace Tests\Feature;

use BabDev\GitHub\Exceptions\BadRequestException;
use BabDev\GitHub\RequestHandler;
use Mockery\MockInterface;
use Tests\TestCase;

final class GitHubWebhookTest extends TestCase
{
    public function test_an_app_webhook_for_an_unsupported_repository_results_in_a_400_response(): void
    {
        config()->set('services.github.apps', []);

        $this->postJson('/webhooks/github/app', ['repository' => ['full_name' => 'BabDev/unsupported']])
            ->assertBadRequest();
    }

    public function test_an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_no_signature_header_results_in_a_403_response(): void
    {
        config()->set(
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

        $this->postJson('/webhooks/github/app', ['repository' => ['full_name' => 'BabDev/test-repo']])
            ->assertForbidden();
    }

    public function test_an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_an_invalid_signature_results_in_a_403_response(): void
    {
        $secret = 'my-secret-value';

        config()->set(
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

        $this->postJson('/webhooks/github/app', $requestData, ['X-Hub-Signature-256' => 'sha256=' . $signatureHeader])
            ->assertForbidden();
    }

    public function test_an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_a_valid_signature_is_processed(): void
    {
        $this->mock(RequestHandler::class, function (MockInterface $mock): void {
            $mock->shouldReceive('handleRequest')->once();
        });

        $secret = 'my-secret-value';

        config()->set(
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

        $this->postJson('/webhooks/github/app', $requestData, ['X-Hub-Signature-256' => 'sha256=' . $signatureHeader])
            ->assertSuccessful();
    }

    public function test_an_app_webhook_for_a_supported_repository_with_a_configured_secret_and_a_valid_signature_is_not_processed_if_an_invalid_request_is_given(): void
    {
        $this->mock(RequestHandler::class, function (MockInterface $mock): void {
            $mock->shouldReceive('handleRequest')->andThrow(new BadRequestException('Invalid request'));
        });

        $secret = 'my-secret-value';

        config()->set(
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

        $this->postJson('/webhooks/github/app', $requestData, ['X-Hub-Signature-256' => 'sha256=' . $signatureHeader])
            ->assertBadRequest();
    }
}

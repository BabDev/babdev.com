<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\JWTConfigurationBuilder;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;

final class JWTConfigurationBuilderTest extends TestCase
{
    #[DoesNotPerformAssertions]
    public function test_the_builder_creates_a_configuration_object_for_a_repository(): void
    {
        $repoConfig = [
            'app_id' => '12345',
            'key' => \dirname(__DIR__) . '/../fixtures/private-key.pem',
            'secret' => 'secret',
            'events' => [],
        ];

        (new JWTConfigurationBuilder())->build($repoConfig);
    }
}

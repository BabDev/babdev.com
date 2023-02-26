<?php

namespace Tests\Unit\GitHub;

use BabDev\Contracts\GitHub\JWTConfigurationBuilder;
use BabDev\GitHub\JWTTokenGenerator;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Blake2b;
use Lcobucci\JWT\Signer\Key\InMemory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class JWTTokenGeneratorTest extends TestCase
{
    #[Test]
    public function the_generator_generates_a_jwt_token_for_a_repository(): void
    {
        $repoConfig = [
            'app_id' => '12345',
            'key' => \dirname(__DIR__) . '/../fixtures/private-key.pem',
            'secret' => 'secret',
            'events' => [],
        ];

        $config = Configuration::forSymmetricSigner(
            new Blake2b(),
            InMemory::base64Encoded('MpQd6dDPiqnzFSWmpUfLy4+Rdls90Ca4C8e0QD0IxqY='),
        );

        /** @var MockObject&JWTConfigurationBuilder $builder */
        $builder = $this->createMock(JWTConfigurationBuilder::class);
        $builder->expects($this->once())
            ->method('build')
            ->with($repoConfig)
            ->willReturn($config);

        $this->assertNotEmpty(
            (new JWTTokenGenerator($builder))->generate($repoConfig),
        );
    }
}

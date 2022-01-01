<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;

final class JWTConfigurationBuilder implements JWTConfigurationBuilderContract
{
    /**
     * @phpstan-param array{app_id: string, key: string, secret: string, events: array<string, array<int, class-string<Action>>>} $repoConfig
     */
    public function build(array $repoConfig): Configuration
    {
        return Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::file($repoConfig['key']),
        );
    }
}

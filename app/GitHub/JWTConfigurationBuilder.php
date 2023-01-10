<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
final class JWTConfigurationBuilder implements JWTConfigurationBuilderContract
{
    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function build(array $repoConfig): Configuration
    {
        return Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::file($repoConfig['key']),
        );
    }
}

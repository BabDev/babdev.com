<?php

namespace App\GitHub;

use App\Contracts\GitHub\Actions\Action;
use App\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use Illuminate\Support\Arr;
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
    public function build(#[\SensitiveParameter] array $repoConfig): Configuration
    {
        return Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::file(Arr::string($repoConfig, 'key')),
        );
    }
}

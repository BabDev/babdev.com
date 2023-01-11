<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use Lcobucci\JWT\Encoding\ChainedFormatter;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
final class JWTTokenGenerator implements JWTTokenGeneratorContract
{
    public function __construct(private readonly JWTConfigurationBuilderContract $configurationBuilder)
    {
    }

    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function generate(array $repoConfig): string
    {
        $config = $this->configurationBuilder->build($repoConfig);

        return $config->builder(ChainedFormatter::withUnixTimestampDates())
            ->issuedBy($repoConfig['app_id'])
            ->issuedAt(now('UTC')->subMinute()->toDateTimeImmutable())
            ->expiresAt(now('UTC')->addMinutes(5)->toDateTimeImmutable())
            ->getToken($config->signer(), $config->signingKey())
            ->toString();
    }
}

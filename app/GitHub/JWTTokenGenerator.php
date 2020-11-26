<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use Carbon\Carbon;

final class JWTTokenGenerator implements JWTTokenGeneratorContract
{
    private JWTConfigurationBuilderContract $configurationBuilder;

    public function __construct(JWTConfigurationBuilderContract $configurationBuilder)
    {
        $this->configurationBuilder = $configurationBuilder;
    }

    public function generate(array $repoConfig): string
    {
        $config = $this->configurationBuilder->build($repoConfig);

        $token = $config->builder()
            ->issuedBy($repoConfig['app_id'])
            ->issuedAt(Carbon::now('UTC')->toDateTimeImmutable())
            ->expiresAt(Carbon::now('UTC')->addMinute()->toDateTimeImmutable())
            ->getToken($config->signer(), $config->signingKey());

        return (string) $token;
    }
}

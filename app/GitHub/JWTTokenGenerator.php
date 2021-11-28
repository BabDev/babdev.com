<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use Carbon\Carbon;
use Lcobucci\JWT\Encoding\ChainedFormatter;

final class JWTTokenGenerator implements JWTTokenGeneratorContract
{
    public function __construct(private JWTConfigurationBuilderContract $configurationBuilder)
    {
    }

    public function generate(array $repoConfig): string
    {
        $config = $this->configurationBuilder->build($repoConfig);

        $token = $config->builder(ChainedFormatter::withUnixTimestampDates())
            ->issuedBy($repoConfig['app_id'])
            ->issuedAt(Carbon::now('UTC')->subMinute()->toDateTimeImmutable())
            ->expiresAt(Carbon::now('UTC')->addMinutes(5)->toDateTimeImmutable())
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }
}

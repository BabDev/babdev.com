<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use Lcobucci\JWT\Encoding\ChainedFormatter;

final class JWTTokenGenerator implements JWTTokenGeneratorContract
{
    public function __construct(private readonly JWTConfigurationBuilderContract $configurationBuilder)
    {
    }

    /**
     * @phpstan-param array{app_id: string, key: string, secret: string, events: array<string, array<int, class-string<Action>>>} $repoConfig
     */
    public function generate(array $repoConfig): string
    {
        $config = $this->configurationBuilder->build($repoConfig);

        $token = $config->builder(ChainedFormatter::withUnixTimestampDates())
            ->issuedBy($repoConfig['app_id'])
            ->issuedAt(now('UTC')->subMinute()->toDateTimeImmutable())
            ->expiresAt(now('UTC')->addMinutes(5)->toDateTimeImmutable())
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }
}

<?php

namespace BabDev\Contracts\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use Lcobucci\JWT\Configuration;

interface JWTConfigurationBuilder
{
    /**
     * @phpstan-param array{app_id: string, key: string, secret: string, events: array<string, array<int, class-string<Action>>>} $repoConfig
     */
    public function build(array $repoConfig): Configuration;
}

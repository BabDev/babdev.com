<?php

namespace BabDev\Contracts\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;

interface JWTTokenGenerator
{
    /**
     * @phpstan-param array{app_id: string, key: string, secret: string, events: array<string, array<int, class-string<Action>>>} $repoConfig
     */
    public function generate(array $repoConfig): string;
}

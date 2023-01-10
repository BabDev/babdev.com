<?php

namespace BabDev\Contracts\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
interface JWTTokenGenerator
{
    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function generate(array $repoConfig): string;
}

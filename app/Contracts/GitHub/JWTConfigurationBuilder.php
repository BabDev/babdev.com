<?php

namespace BabDev\Contracts\GitHub;

use BabDev\Contracts\GitHub\Actions\Action;
use Lcobucci\JWT\Configuration;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
interface JWTConfigurationBuilder
{
    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function build(array $repoConfig): Configuration;
}

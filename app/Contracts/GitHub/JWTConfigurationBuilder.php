<?php

namespace App\Contracts\GitHub;

use App\Contracts\GitHub\Actions\Action;
use Lcobucci\JWT\Configuration;

/**
 * @phpstan-import-type GitHubRepoConfig from Action
 */
interface JWTConfigurationBuilder
{
    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function build(#[\SensitiveParameter] array $repoConfig): Configuration;
}

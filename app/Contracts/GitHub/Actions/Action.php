<?php

namespace BabDev\Contracts\GitHub\Actions;

use Github\Client;
use Illuminate\Http\Request;

/**
 * @phpstan-type GitHubRepoConfig array{app_id: non-empty-string, key: non-empty-string, secret: non-empty-string, events: array<string, list<class-string<Action>>>}
 */
interface Action
{
    /**
     * @phpstan-param GitHubRepoConfig $repoConfig
     */
    public function __invoke(#[\SensitiveParameter] array $repoConfig, Request $request, Client $github): void;
}

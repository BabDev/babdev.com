<?php

namespace BabDev\Contracts\GitHub\Actions;

use Github\Client;
use Illuminate\Http\Request;

interface Action
{
    /**
     * @phpstan-param array{app_id: string, key: string, secret: string, events: array<string, array<int, class-string<Action>>>} $repoConfig
     */
    public function __invoke(array $repoConfig, Request $request, Client $github): void;
}

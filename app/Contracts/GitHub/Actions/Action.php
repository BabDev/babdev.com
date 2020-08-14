<?php

namespace BabDev\Contracts\GitHub\Actions;

use Github\Client;
use Illuminate\Http\Request;

interface Action
{
    public function __invoke(array $repoConfig, Request $request, Client $github): void;
}

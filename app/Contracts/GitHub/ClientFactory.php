<?php

namespace BabDev\Contracts\GitHub;

use Github\Client;
use Github\HttpClient\Builder;

interface ClientFactory
{
    public function make(?Builder $httpClientBuilder = null, ?string $apiVersion = null, ?string $enterpriseUrl = null): Client;
}

<?php

namespace BabDev\GitHub;

use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

class ApiConnector
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchPublicRepositories(string $username): Collection
    {
        return (new Collection((new ResultPager($this->client))->fetchAll($this->client->api('organization'), 'repositories', [$username])))
            ->filter(
                static function ($repo) {
                    return $repo['private'] === false;
                }
            );
    }

    public function fetchRepositoryTopics(string $username, string $repository): Collection
    {
        return new Collection($this->client->api('repository')->topics($username, $repository)['names'] ?? []);
    }
}

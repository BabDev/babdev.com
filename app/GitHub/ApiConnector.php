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

    public function addRepositoryLabel(string $username, string $repository, string $label, string $color): void
    {
        $this->client->api('repository')->labels()->create(
            $username,
            $repository,
            [
                'name' => $label,
                'color' => $color,
            ]
        );
    }

    public function fetchFileContents(string $username, string $repository, string $path, string $reference): array
    {
        return $this->client->api('repositories')->contents()->show($username, $repository, $path, $reference);
    }

    public function fetchPublicRepositories(string $username): Collection
    {
        return (new Collection((new ResultPager($this->client))->fetchAll($this->client->api('organization'), 'repositories', [$username])))
            ->filter(static fn (array $repo): bool => !$repo['private']);
    }

    public function fetchRepositoryLabels(string $username, string $repository): Collection
    {
        return new Collection($this->client->api('repository')->labels()->all($username, $repository));
    }

    public function fetchRepositoryTopics(string $username, string $repository): Collection
    {
        return new Collection($this->client->api('repository')->topics($username, $repository)['names'] ?? []);
    }

    public function replaceRepositoryTopics(string $username, string $repository, array $topics): void
    {
        $this->client->api('repository')->replaceTopics($username, $repository, $topics);
    }
}

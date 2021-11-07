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
        $this->client->repository()->labels()->create(
            $username,
            $repository,
            [
                'name' => $label,
                'color' => $color,
            ],
        );
    }

    public function executeGraphqlQuery(string $query, array $variables = []): array
    {
        return $this->client->graphql()->execute($query, $variables);
    }

    public function fetchFileContents(string $username, string $repository, string $path, string $reference): array
    {
        return $this->client->repositories()->contents()->show($username, $repository, $path, $reference);
    }

    /**
     * @return Collection<array>
     */
    public function fetchPublicRepositories(string $username): Collection
    {
        return (new Collection((new ResultPager($this->client))->fetchAll($this->client->api('organization'), 'repositories', [$username])))
            ->filter(static fn (array $repo): bool => !$repo['private']);
    }

    /**
     * @return Collection<string>
     */
    public function fetchRepositoryLabels(string $username, string $repository): Collection
    {
        return new Collection($this->client->repository()->labels()->all($username, $repository));
    }

    /**
     * @return Collection<string>
     */
    public function fetchRepositoryTopics(string $username, string $repository): Collection
    {
        return new Collection($this->client->repository()->topics($username, $repository)['names'] ?? []);
    }

    /**
     * @param string[] $topics
     */
    public function replaceRepositoryTopics(string $username, string $repository, array $topics): void
    {
        $this->client->repository()->replaceTopics($username, $repository, $topics);
    }
}

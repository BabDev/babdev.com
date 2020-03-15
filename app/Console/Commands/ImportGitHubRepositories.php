<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class ImportGitHubRepositories extends Command
{
    protected $signature = 'import:github-repositories';

    protected $description = 'Import GitHub repositories to the application.';

    private ApiConnector $github;
    private CacheContract $cache;

    public function __construct(ApiConnector $github, CacheContract $cache)
    {
        $this->github = $github;
        $this->cache = $cache;

        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Syncing all repositories...');

        $this->github->fetchPublicRepositories('BabDev')->each(
            function (array $repositoryAttributes): void {
                $this->comment("Importing `{$repositoryAttributes['name']}`... ");

                Package::query()->updateOrCreate(
                    ['name' => $repositoryAttributes['name'] ?? null],
                    [
                        'name' => $repositoryAttributes['name'],
                        'display_name' => ucwords(str_replace(['-', '_'], ' ', $repositoryAttributes['name'])),
                        'description' => $repositoryAttributes['description'],
                        'topics' => $this->cache->remember(
                            "github-repository_topics-{$repositoryAttributes['name']}",
                            3600,
                            function () use ($repositoryAttributes) {
                                return $this->github->fetchRepositoryTopics('BabDev', $repositoryAttributes['name']);
                            }
                        ),
                        'stars' => $repositoryAttributes['stargazers_count'],
                        'language' => $repositoryAttributes['language'],
                        'supported' => $repositoryAttributes['archived'] === false,
                    ]
                );
            }
        );

        $this->info('All done!');
    }
}

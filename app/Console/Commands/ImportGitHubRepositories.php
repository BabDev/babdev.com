<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use Illuminate\Console\Command;

class ImportGitHubRepositories extends Command
{
    protected $signature = 'import:github-repositories';

    protected $description = 'Import GitHub repositories to the application.';

    private ApiConnector $github;

    public function __construct(ApiConnector $github)
    {
        $this->github = $github;

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
                        'display_name' => \ucwords(\str_replace(['-', '_'], ' ', $repositoryAttributes['name'])),
                        'description' => $repositoryAttributes['description'],
                        'topics' => $this->github->fetchRepositoryTopics('BabDev', $repositoryAttributes['name']),
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

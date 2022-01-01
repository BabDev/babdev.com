<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportGitHubRepositories extends Command
{
    protected $name = 'import:github-repositories';

    protected $description = 'Import GitHub repositories to the application.';

    public function handle(ApiConnector $github): void
    {
        $this->info('Syncing all repositories...');

        $github->fetchPublicRepositories('BabDev')
            ->filter(static function (array $repositoryAttributes): bool {
                $name = Arr::get($repositoryAttributes, 'name');

                // Ignore if missing name
                if ($name === null) {
                    return false;
                }

                // Ignore selected org repositories
                if (\in_array($name, ['babdev.com', 'PhpSpecSkipExampleExtension'], true)) {
                    return false;
                }

                return true;
            })
            ->each(function (array $repositoryAttributes) use ($github): void {
                /** @phpstan-var string $name */
                $name = Arr::get($repositoryAttributes, 'name');

                $this->comment("Importing `{$name}`... ");

                Package::query()->updateOrCreate(
                    ['name' => $name],
                    [
                        'name' => $name,
                        'display_name' => ucwords(str_replace(['-', '_'], ' ', $name)),
                        'description' => Arr::get($repositoryAttributes, 'description'),
                        'topics' => $github->fetchRepositoryTopics('BabDev', $name),
                        'stars' => Arr::get($repositoryAttributes, 'stargazers_count'),
                        'language' => Arr::get($repositoryAttributes, 'language'),
                        'supported' => Arr::get($repositoryAttributes, 'archived') === false,
                    ],
                );
            });

        $this->info('All done!');
    }
}

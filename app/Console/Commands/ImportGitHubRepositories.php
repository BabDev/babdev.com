<?php

namespace App\Console\Commands;

use App\GitHub\ApiConnector;
use App\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'import:github-repositories', description: 'Import GitHub repositories to the application.')]
final class ImportGitHubRepositories extends Command
{
    public function handle(ApiConnector $github): void
    {
        $this->components->info('Syncing all repositories...');

        $github->fetchPublicRepositories('BabDev')
            ->filter(static fn(array $repositoryAttributes): bool => Arr::string($repositoryAttributes, 'name') !== 'babdev.com')
            ->each(function (array $repositoryAttributes) use ($github): void {
                $name = Arr::string($repositoryAttributes, 'name');

                $this->components->info("Importing `$name`... ");

                tap(Package::firstOrNew(['name' => $name]), function (Package $package) use ($name, $repositoryAttributes, $github): void {
                    $package->fill([
                        'name' => $name,
                        'description' => Arr::string($repositoryAttributes, 'description'),
                        'topics' => $github->fetchRepositoryTopics('BabDev', $name),
                        'stars' => Arr::integer($repositoryAttributes, 'stargazers_count'),
                        'language' => Arr::string($repositoryAttributes, 'language'),
                        'supported' => !Arr::boolean($repositoryAttributes, 'archived'),
                    ]);

                    // Only set the display name on create so it can be customized in-app
                    if (!$package->exists) {
                        $package->display_name = Str::headline($name);
                    }

                    $package->save();
                });
            });

        $this->components->success('All done!');
    }
}

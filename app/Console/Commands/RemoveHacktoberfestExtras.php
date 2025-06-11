<?php

namespace App\Console\Commands;

use App\GitHub\ApiConnector;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'hacktoberfest:remove', description: 'Removes extras for Hacktoberfest from active repositories.')]
final class RemoveHacktoberfestExtras extends Command
{
    public function handle(ApiConnector $github): void
    {
        $this->components->info('Updating all repositories...');

        $github->fetchPublicRepositories('BabDev')
            ->filter(static function (array $repositoryAttributes): bool {
                // Ignore this website
                if (Arr::string($repositoryAttributes, 'name') === 'babdev.com') {
                    return false;
                }

                // Ignore archived repositories
                return !Arr::boolean($repositoryAttributes, 'archived');
            })
            ->each(function (array $repositoryAttributes) use ($github): void {
                $name = Arr::string($repositoryAttributes, 'name');

                $topics = $github->fetchRepositoryTopics('BabDev', $name);

                if ($topics->contains('hacktoberfest')) {
                    $this->components->info("Removing 'hacktoberfest' topic from `$name`... ");

                    $github->replaceRepositoryTopics(
                        'BabDev',
                        $name,
                        $topics->filter(static fn(string $label): bool => $label !== 'hacktoberfest')->toArray(),
                    );
                } else {
                    $this->components->info("'hacktoberfest' topic does not exist on `$name`... ");
                }
            });

        $this->components->success('All done!');
    }
}

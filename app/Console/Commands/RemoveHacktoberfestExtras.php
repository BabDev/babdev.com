<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'hacktoberfest:remove', description: 'Removes extras for Hacktoberfest from active repositories.')]
class RemoveHacktoberfestExtras extends Command
{
    protected $name = 'hacktoberfest:remove';

    protected $description = 'Removes extras for Hacktoberfest from active repositories.';

    public function handle(ApiConnector $github): void
    {
        $this->info('Updating all repositories...');

        $github->fetchPublicRepositories('BabDev')
            ->filter(static function (array $repositoryAttributes): bool {
                // Ignore this website
                if ($repositoryAttributes['name'] === 'babdev.com') {
                    return false;
                }

                // Ignore archived repositories
                if ($repositoryAttributes['archived']) {
                    return false;
                }

                return true;
            })
            ->each(function (array $repositoryAttributes) use ($github): void {
                $topics = $github->fetchRepositoryTopics('BabDev', $repositoryAttributes['name']);

                if ($topics->contains('hacktoberfest')) {
                    $this->comment("Removing 'hacktoberfest' topic from `{$repositoryAttributes['name']}`... ");
                    $topics = $topics->filter(static fn (string $label): bool => $label !== 'hacktoberfest');

                    $github->replaceRepositoryTopics(
                        'BabDev',
                        $repositoryAttributes['name'],
                        $topics->toArray(),
                    );
                } else {
                    $this->comment("'hacktoberfest' topic does not exist on `{$repositoryAttributes['name']}`... ");
                }
            });

        $this->info('All done!');
    }
}

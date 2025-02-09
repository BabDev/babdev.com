<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'hacktoberfest:add', description: 'Adds extras for Hacktoberfest to active repositories.')]
final class AddHacktoberfestExtras extends Command
{
    protected $name = 'hacktoberfest:add';

    protected $description = 'Adds extras for Hacktoberfest to active repositories.';

    public function handle(ApiConnector $github): void
    {
        $this->components->info('Updating all repositories...');

        $github->fetchPublicRepositories('BabDev')
            ->filter(static function (array $repositoryAttributes): bool {
                // Ignore this website
                if ($repositoryAttributes['name'] === 'babdev.com') {
                    return false;
                }

                // Ignore archived repositories
                return !$repositoryAttributes['archived'];
            })
            ->each(function (array $repositoryAttributes) use ($github): void {
                $labels = $github->fetchRepositoryLabels('BabDev', $repositoryAttributes['name']);
                $topics = $github->fetchRepositoryTopics('BabDev', $repositoryAttributes['name']);

                if (!$topics->contains('hacktoberfest')) {
                    $this->components->info("Adding 'hacktoberfest' topic to `{$repositoryAttributes['name']}`... ");
                    $topics->add('hacktoberfest');

                    $github->replaceRepositoryTopics(
                        'BabDev',
                        $repositoryAttributes['name'],
                        $topics->toArray(),
                    );
                } else {
                    $this->components->warn("'hacktoberfest' topic already exists on `{$repositoryAttributes['name']}`... ");
                }

                $hacktoberfestLabels = [
                    'hacktoberfest-accepted' => '9c4668',
                    'invalid' => 'ca0b00',
                    'spam' => 'b33a3a',
                ];

                foreach ($hacktoberfestLabels as $labelName => $labelColor) {
                    $matchingLabel = $labels->firstWhere('name', '=', $labelName);

                    if ($matchingLabel === null) {
                        $this->components->info("Adding '$labelName' label to `{$repositoryAttributes['name']}`... ");

                        $github->addRepositoryLabel('BabDev', $repositoryAttributes['name'], $labelName, $labelColor);
                    } else {
                        $this->components->warn("'$labelName' label already exists on `{$repositoryAttributes['name']}`... ");
                    }
                }
            });

        $this->components->info('All done!');
    }
}

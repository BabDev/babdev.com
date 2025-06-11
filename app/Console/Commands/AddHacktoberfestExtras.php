<?php

namespace App\Console\Commands;

use App\GitHub\ApiConnector;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'hacktoberfest:add', description: 'Adds extras for Hacktoberfest to active repositories.')]
final class AddHacktoberfestExtras extends Command
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

                $labels = $github->fetchRepositoryLabels('BabDev', $name);
                $topics = $github->fetchRepositoryTopics('BabDev', $name);

                if (!$topics->contains('hacktoberfest')) {
                    $this->components->info("Adding 'hacktoberfest' topic to `$name`... ");
                    $topics->add('hacktoberfest');

                    $github->replaceRepositoryTopics(
                        'BabDev',
                        $name,
                        $topics->toArray(),
                    );
                } else {
                    $this->components->warn("'hacktoberfest' topic already exists on `{$name}`... ");
                }

                $hacktoberfestLabels = [
                    'hacktoberfest-accepted' => '9c4668',
                    'invalid' => 'ca0b00',
                    'spam' => 'b33a3a',
                ];

                foreach ($hacktoberfestLabels as $labelName => $labelColor) {
                    $matchingLabel = $labels->firstWhere('name', '=', $labelName);

                    if ($matchingLabel === null) {
                        $this->components->info("Adding '$labelName' label to `{$name}`... ");

                        $github->addRepositoryLabel('BabDev', $name, $labelName, $labelColor);
                    } else {
                        $this->components->warn("'$labelName' label already exists on `{$name}`... ");
                    }
                }
            });

        $this->components->info('All done!');
    }
}

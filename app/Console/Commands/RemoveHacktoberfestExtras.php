<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use Illuminate\Console\Command;

class RemoveHacktoberfestExtras extends Command
{
    protected $name = 'hacktoberfest:remove';

    protected $description = 'Removes extras for Hacktoberfest from active repositories.';

    private ApiConnector $github;

    public function __construct(ApiConnector $github)
    {
        $this->github = $github;

        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Updating all repositories...');

        $this->github->fetchPublicRepositories('BabDev')->each(
            function (array $repositoryAttributes): void {
                // Ignore this website
                if ($repositoryAttributes['name'] === 'babdev.com') {
                    return;
                }

                // Ignore archived repositories
                if ($repositoryAttributes['archived']) {
                    return;
                }

                $labels = $this->github->fetchRepositoryLabels('BabDev', $repositoryAttributes['name']);
                $topics = $this->github->fetchRepositoryTopics('BabDev', $repositoryAttributes['name']);

                if ($topics->contains('hacktoberfest')) {
                    $this->comment("Removing 'hacktoberfest' topic from `{$repositoryAttributes['name']}`... ");
                    $topics = $topics->filter(static function (string $label): bool {
                        return $label !== 'hacktoberfest';
                    });

                    $this->github->replaceRepositoryTopics('BabDev', $repositoryAttributes['name'], $topics->toArray());
                } else {
                    $this->comment("'hacktoberfest' topic does not exist on `{$repositoryAttributes['name']}`... ");
                }
            }
        );

        $this->info('All done!');
    }
}

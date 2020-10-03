<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use Illuminate\Console\Command;

class AddHacktoberfestExtras extends Command
{
    protected $signature = 'hacktoberfest:add';

    protected $description = 'Adds extras for Hacktoberfest to active repositories.';

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

                if (!$topics->contains('hacktoberfest')) {
                    $this->comment("Adding 'hacktoberfest' topic to `{$repositoryAttributes['name']}`... ");
                    $topics->add('hacktoberfest');

                    $this->github->replaceRepositoryTopics('BabDev', $repositoryAttributes['name'], $topics->toArray());
                } else {
                    $this->comment("'hacktoberfest' topic already exists on `{$repositoryAttributes['name']}`... ");
                }

                $hacktoberfestLabels = [
                    'hacktoberfest-accepted' => '9c4668',
                    'invalid' => 'ca0b00',
                    'spam' => 'b33a3a',
                ];

                foreach ($hacktoberfestLabels as $labelName => $labelColor) {
                    $matchingLabel = $labels->firstWhere('name', '=', $labelName);

                    if ($matchingLabel === null) {
                        $this->comment("Adding '$labelName' label to `{$repositoryAttributes['name']}`... ");

                        $this->github->addRepositoryLabel('BabDev', $repositoryAttributes['name'], $labelName, $labelColor);
                    } else {
                        $this->comment("'$labelName' label already exists on `{$repositoryAttributes['name']}`... ");
                    }
                }
            }
        );

        $this->info('All done!');
    }
}

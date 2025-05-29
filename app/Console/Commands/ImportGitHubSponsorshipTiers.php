<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\SponsorshipTier;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'import:github-sponsorship-tiers', description: 'Import GitHub sponsorship tiers to the application.')]
final class ImportGitHubSponsorshipTiers extends Command
{
    protected $name = 'import:github-sponsorship-tiers';

    protected $description = 'Import GitHub sponsorship tiers to the application.';

    public function handle(ApiConnector $github): void
    {
        $this->components->info('Syncing sponsorship tiers...');

        // TODO - Pagination support
        $query = <<<GRAPHQL
            {
              viewer {
                sponsorsListing {
                  tiers(first: 10) {
                    edges {
                      node {
                        id
                        name
                        isOneTime
                        monthlyPriceInCents
                      }
                    }
                    pageInfo {
                      hasNextPage
                      endCursor
                    }
                  }
                }
              }
            }
            GRAPHQL;

        $response = $github->executeGraphqlQuery($query);

        /** @var array<string, mixed> $tierEdge */
        foreach (Arr::array($response, 'data.viewer.sponsorsListing.tiers.edges', []) as $tierEdge) {
            SponsorshipTier::updateOrCreate(['node_id' => Arr::string($tierEdge, 'node.id')], [
                'node_id' => Arr::string($tierEdge, 'node.id'),
                'one_time' => Arr::boolean($tierEdge, 'node.isOneTime'),
                'price' => Arr::integer($tierEdge, 'node.monthlyPriceInCents'),
            ]);
        }

        $this->components->success('All done!');
    }
}

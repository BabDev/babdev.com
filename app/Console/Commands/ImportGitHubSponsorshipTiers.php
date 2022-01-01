<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\SponsorshipTier;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportGitHubSponsorshipTiers extends Command
{
    protected $name = 'import:github-sponsorship-tiers';

    protected $description = 'Import GitHub sponsorship tiers to the application.';

    public function handle(ApiConnector $github): void
    {
        $this->info('Syncing sponsorship tiers...');

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

        /** @var array $tierEdge */
        foreach (Arr::get($response, 'data.viewer.sponsorsListing.tiers.edges', []) as $tierEdge) {
            SponsorshipTier::query()->updateOrCreate(
                ['node_id' => Arr::get($tierEdge, 'node.id')],
                [
                    'node_id' => Arr::get($tierEdge, 'node.id'),
                    'one_time' => Arr::get($tierEdge, 'node.isOneTime'),
                    'price' => Arr::get($tierEdge, 'node.monthlyPriceInCents'),
                ],
            );
        }

        $this->info('All done!');
    }
}

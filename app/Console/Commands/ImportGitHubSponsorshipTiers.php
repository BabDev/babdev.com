<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportGitHubSponsorshipTiers extends Command
{
    protected $name = 'import:github-sponsorship-tiers';

    protected $description = 'Import GitHub sponsorship tiers to the application.';

    private ApiConnector $github;

    public function __construct(ApiConnector $github)
    {
        $this->github = $github;

        parent::__construct();
    }

    public function handle(): void
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

        $response = $this->github->executeGraphqlQuery($query);

        foreach (Arr::get($response, 'data.viewer.sponsorsListing.tiers.edges', []) as $tierEdge) {
        }

        $this->info('All done!');
    }
}

<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Sponsor;
use BabDev\Models\SponsorshipTier;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportGitHubSponsors extends Command
{
    protected $name = 'import:github-sponsors';

    protected $description = 'Import GitHub sponsors to the application.';

    private ApiConnector $github;

    public function __construct(ApiConnector $github)
    {
        $this->github = $github;

        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Syncing sponsors...');

        // TODO - Pagination support
        $query = <<<GRAPHQL
            {
              viewer {
                sponsorshipsAsMaintainer(first: 10) {
                  edges {
                    node {
                      id
                      privacyLevel
                      sponsorEntity {
                        ... on User {
                          id
                          login
                          name
                        }
                      }
                      tier {
                        id
                      }
                    }
                  }
                  pageInfo {
                    hasNextPage
                    endCursor
                  }
                }
              }
            }
            GRAPHQL;

        $response = $this->github->executeGraphqlQuery($query);

        foreach (Arr::get($response, 'data.viewer.sponsorshipsAsMaintainer.edges', []) as $sponsorEdge) {
            /** @var Sponsor $sponsor */
            $sponsor = Sponsor::query()->firstOrNew(
                ['sponsorship_node_id' => Arr::get($sponsorEdge, 'node.id')],
                [
                    'sponsorship_node_id' => Arr::get($sponsorEdge, 'node.id'),
                    'is_public' => Arr::get($sponsorEdge, 'node.privacyLevel') === 'PUBLIC',
                    'sponsor_node_id' => Arr::get($sponsorEdge, 'node.sponsorEntity.id'),
                    'sponsor_username' => Arr::get($sponsorEdge, 'node.sponsorEntity.login'),
                    'sponsor_display_name' => Arr::get($sponsorEdge, 'node.sponsorEntity.name'),
                ]
            );

            /** @var SponsorshipTier $sponsorshipTier */
            $sponsorshipTier = SponsorshipTier::query()
                ->where('node_id', '=', Arr::get($sponsorEdge, 'node.tier.id'))
                ->firstOrFail();

            $sponsor->sponsorship_tier()->associate($sponsorshipTier);
            $sponsor->save();
        }

        $this->info('All done!');
    }
}

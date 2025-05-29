<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Sponsor;
use BabDev\Models\SponsorshipTier;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'import:github-sponsors', description: 'Import GitHub sponsors to the application.')]
final class ImportGitHubSponsors extends Command
{
    protected $name = 'import:github-sponsors';

    protected $description = 'Import GitHub sponsors to the application.';

    public function handle(ApiConnector $github): void
    {
        $this->components->info('Syncing sponsors...');

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

        $response = $github->executeGraphqlQuery($query);

        $activeSponsorIds = [];

        /** @var array<string, mixed> $sponsorEdge */
        foreach (Arr::array($response, 'data.viewer.sponsorshipsAsMaintainer.edges', []) as $sponsorEdge) {
            $activeSponsorIds[] = Arr::string($sponsorEdge, 'node.id');

            /** @var Sponsor $sponsor */
            $sponsor = Sponsor::firstOrNew(['sponsorship_node_id' => Arr::string($sponsorEdge, 'node.id')], [
                'sponsorship_node_id' => Arr::string($sponsorEdge, 'node.id'),
                'is_public' => Arr::string($sponsorEdge, 'node.privacyLevel') === 'PUBLIC',
                'sponsor_node_id' => Arr::string($sponsorEdge, 'node.sponsorEntity.id'),
                'sponsor_username' => Arr::string($sponsorEdge, 'node.sponsorEntity.login'),
                'sponsor_display_name' => Arr::get($sponsorEdge, 'node.sponsorEntity.name'),
            ]);

            $sponsorshipTier = SponsorshipTier::whereNodeId(Arr::string($sponsorEdge, 'node.tier.id'))
                ->firstOrFail();

            $sponsor->sponsorship_tier()->associate($sponsorshipTier);
            $sponsor->save();
        }

        Sponsor::whereNotIn('sponsorship_node_id', $activeSponsorIds)
            ->delete();

        $this->components->success('All done!');
    }
}

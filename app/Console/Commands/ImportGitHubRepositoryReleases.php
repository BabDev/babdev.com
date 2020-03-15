<?php

namespace BabDev\Console\Commands;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use BabDev\ReleaseStability;
use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class ImportGitHubRepositoryReleases extends Command
{
    protected $signature = 'import:github-repository-releases';

    protected $description = 'Import GitHub repository tags to the application for supported repositories.';

    private ApiConnector $github;
    private CacheContract $cache;

    public function __construct(ApiConnector $github, CacheContract $cache)
    {
        $this->github = $github;
        $this->cache = $cache;

        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Syncing all repositories...');

        Package::query()->hasLocalReleases()->get()->each(
            function (Package $package): void {
                $this->comment("Importing `{$package->name}` releases... ");

                $this->github->fetchRepositoryTags('BabDev', $package->name)->each(
                    function (array $tagAttributes) use ($package): void {
                        $this->comment("Importing `{$tagAttributes['name']}`... ");
                        $package->releases()->updateOrCreate(
                            ['version' => $tagAttributes['name']],
                            [
                                'version' => $tagAttributes['name'],
                                'maturity' => $this->determineStability($tagAttributes['name']),
                            ]
                        );
                    }
                );
            }
        );

        $this->info('All done!');
    }

    private function determineStability(string $version): string
    {
        if (strpos($version, 'alpha') !== false) {
            return ReleaseStability::ALPHA;
        }

        if (strpos($version, 'beta') !== false) {
            return ReleaseStability::BETA;
        }

        if (strpos($version, 'rc') !== false) {
            return ReleaseStability::RC;
        }

        return ReleaseStability::STABLE;
    }
}

<?php

namespace BabDev\Console\Commands;

use GuzzleHttp\Psr7\Uri;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'sitemap:generate', description: 'Generate the sitemap.')]
final class GenerateSitemap extends Command
{
    protected $name = 'sitemap:generate';

    protected $description = 'Generate the sitemap.';

    public function handle(): void
    {
        $this->info('Generating sitemap...');

        SitemapGenerator::create(config('app.url'))
            ->shouldCrawl(static function (Uri $uri): bool {
                // Don't include the homepage without a trailing slash
                if ($uri->getPath() === '') {
                    return false;
                }

                // Don't include docs shortcuts
                if (str_ends_with($uri->getPath(), '/docs')) {
                    return false;
                }

                return !str_ends_with($uri->getPath(), '/docs/intro');
            })
            ->hasCrawled(static function (Url $url): Url {
                if ($url->path() === '/') {
                    $url->setPriority(1.0);
                }

                if (preg_match('/^\/open-source\/packages\/.*\/docs/', $url->path()) || str_starts_with($url->path(), '/open-source/updates/')) {
                    $url->setPriority(0.5);
                }

                return $url;
            })
            ->getSitemap()
            ->writeToDisk('local', 'sitemap.xml');

        $this->info('Sitemap generated!');
    }
}

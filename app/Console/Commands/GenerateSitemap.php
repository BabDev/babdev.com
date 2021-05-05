<?php

namespace BabDev\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $name = 'sitemap:generate';

    protected $description = 'Generate the sitemap.';

    public function handle(): void
    {
        $this->info('Generating sitemap...');

        SitemapGenerator::create(config('app.url'))
            ->hasCrawled(static function (Url $url): ?Url {
                // Don't include the homepage without a trailing slash
                if ($url->path() === '') {
                    return null;
                }

                // Don't include docs shortcuts
                if (substr($url->path(), -5) === '/docs') {
                    return null;
                }

                if (substr($url->path(), -11) === '/docs/intro') {
                    return null;
                }

                return $url;
            })
            ->getSitemap()
            ->writeToDisk('local', 'sitemap.xml');

        $this->info('Sitemap generated!');
    }
}

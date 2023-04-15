<?php

namespace Tests\Unit\Console;

use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Tests\TestCase;

final class SitemapGeneratorTest extends TestCase
{
    public function test_the_sitemap_is_generated(): void
    {
        $disk = Storage::fake('local');

        $this->mock(SitemapGenerator::class, function (MockInterface $mock): void {
            $mock->shouldReceive('setUrl')->once()->andReturnSelf();
            $mock->shouldReceive('shouldCrawl')->once()->andReturnSelf();
            $mock->shouldReceive('hasCrawled')->once()->andReturnSelf();
            $mock->shouldReceive('getSitemap')->once()->andReturn(Sitemap::create());
        });

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        $disk->assertExists('sitemap.xml');
    }
}

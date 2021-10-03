<?php

namespace Tests\Unit\Console;

use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Tests\TestCase;

class SitemapGeneratorTest extends TestCase
{
    /** @test */
    public function the_sitemap_is_generated(): void
    {
        Storage::fake('local');

        $this->instance(
            SitemapGenerator::class,
            \Mockery::mock(SitemapGenerator::class, function (MockInterface $mock): void {
                $mock->shouldReceive('setUrl')->once()->andReturnSelf();
                $mock->shouldReceive('shouldCrawl')->once()->andReturnSelf();
                $mock->shouldReceive('hasCrawled')->once()->andReturnSelf();
                $mock->shouldReceive('getSitemap')->once()->andReturn(Sitemap::create());
            }),
        );

        $this->artisan('sitemap:generate')
            ->assertExitCode(0);

        Storage::disk('local')->assertExists('sitemap.xml');
    }
}

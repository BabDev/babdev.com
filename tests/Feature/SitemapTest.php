<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class SitemapTest extends TestCase
{
    /** @test */
    public function the_sitemap_can_be_returned()
    {
        Storage::fake('local');

        Storage::put('sitemap.xml', \file_get_contents(__DIR__ . '/../fixtures/sitemap.xml'));

        $this->get('/sitemap.xml')
            ->assertOk();
    }

    /** @test */
    public function the_sitemap_returns_a_404_if_it_was_not_generated()
    {
        Storage::fake('local');

        $this->get('/sitemap.xml')
            ->assertNotFound();
    }
}

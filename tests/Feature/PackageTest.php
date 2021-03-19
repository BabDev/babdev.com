<?php

namespace Tests\Feature;

use BabDev\Models\Package;
use BabDev\Models\PackageUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PackageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_view_the_package_listing()
    {
        Package::factory()->count(3)->create();

        $this->get('/open-source/packages')
            ->assertOk()
            ->assertViewIs('open_source.packages.index');
    }

    /** @test */
    public function users_can_view_the_package_update_list()
    {
        PackageUpdate::factory()->count(5)->create();

        $this->get('/open-source/updates')
            ->assertOk()
            ->assertViewIs('open_source.updates.index')
            ->assertSee('<title>Open Source Updates | BabDev</title>', false)
            ->assertDontSee('<link rel="canonical"', false)
            ->assertDontSee('<link rel="prev"', false)
            ->assertDontSee('<link rel="next"', false)
            ->assertDontSee('<ul class="pagination">', false)
            ->assertDontSee('<li class="breadcrumb-item active">Page 1</li>', false);
    }

    /** @test */
    public function users_can_view_a_specific_page_from_the_package_update_list()
    {
        PackageUpdate::factory()->count(40)->create();

        $this->get('/open-source/updates/page/2')
            ->assertOk()
            ->assertViewIs('open_source.updates.index')
            ->assertSee('<title>Page 2 | Open Source Updates | BabDev</title>', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('<link rel="prev"', false)
            ->assertSee('<link rel="next"', false)
            ->assertSee('<ul class="pagination">', false)
            ->assertSee('<li class="breadcrumb-item active">Page 2</li>', false);
    }

    /** @test */
    public function users_are_redirected_to_the_canonical_first_page_of_the_package_update_list()
    {
        PackageUpdate::factory()->count(5)->create();

        $this->get('/open-source/updates/page/1')
            ->assertRedirect('/open-source/updates');
    }

    /** @test */
    public function the_package_update_list_returns_a_404_if_navigating_outside_the_pagination_range()
    {
        PackageUpdate::factory()->count(5)->create();

        $this->get('/open-source/updates/page/2')
            ->assertNotFound();
    }

    /** @test */
    public function users_can_view_a_published_package_update()
    {
        /** @var PackageUpdate $update */
        $update = PackageUpdate::factory()->create();

        $this->get(\sprintf('/open-source/updates/%s', $update->slug))
            ->assertOk()
            ->assertViewIs('open_source.updates.show');
    }

    /** @test */
    public function users_can_not_view_an_unpublished_package_update()
    {
        /** @var PackageUpdate $update */
        $update = PackageUpdate::factory()->unpublished()->create();

        $this->get(\sprintf('/open-source/updates/%s', $update->slug))
            ->assertNotFound();
    }
}

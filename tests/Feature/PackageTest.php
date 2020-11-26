<?php

namespace Tests\Feature;

use BabDev\Models\Package;
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
}

<?php

namespace Tests\Unit\View;

use BabDev\Models\Package;
use BabDev\View\Components\PackageTitle;
use Tests\TestCase;

final class PackageTitleComponentTest extends TestCase
{
    public function test_the_component_is_rendered_with_no_secondary_title(): void
    {
        /** @var Package $package */
        $package = Package::factory()->notVisible()->make();

        $this->component(PackageTitle::class, ['package' => $package])
            ->assertSee('<h1 class="package-title__primary">' . $package->display_name . '</h1>', false)
            ->assertDontSee('<h2 class="package-title__secondary">', false);
    }

    public function test_the_component_is_rendered_with_a_secondary_title(): void
    {
        /** @var Package $package */
        $package = Package::factory()->notVisible()->make();

        $this->component(PackageTitle::class, ['package' => $package, 'secondaryTitle' => 'Secondary Test'])
            ->assertSee('<h1 class="package-title__primary">' . $package->display_name . '</h1>', false)
            ->assertSee('<h2 class="package-title__secondary">Secondary Test</h2>', false);
    }
}

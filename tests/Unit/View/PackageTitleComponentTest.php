<?php

namespace Tests\Unit\View;

use BabDev\Models\Package;
use BabDev\View\Components\PackageTitle;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PackageTitleComponentTest extends TestCase
{
    #[Test]
    public function the_component_is_rendered_with_no_logo(): void
    {
        /** @var Package $package */
        $package = Package::factory()->notVisible()->make();

        $this->component(PackageTitle::class, ['package' => $package])
            ->assertSee('<h1 class="package-title__primary">' . $package->display_name . '</h1>', false)
            ->assertDontSee('<div class="package-title__logo">', false)
            ->assertDontSee('<h2 class="package-title__secondary">', false);
    }

    #[Test]
    public function the_component_is_rendered_with_a_logo(): void
    {
        Storage::fake('logos')
            ->put('logo.svg', file_get_contents(__DIR__ . '/../../fixtures/logo.svg'));

        /** @var Package $package */
        $package = Package::factory()->notVisible()->make();
        $package->logo = 'logo.svg';

        $this->component(PackageTitle::class, ['package' => $package])
            ->assertSee('<h1 class="package-title__primary">' . $package->display_name . '</h1>', false)
            ->assertSee('<div class="package-title__logo">', false)
            ->assertDontSee('<h2 class="package-title__secondary">', false);
    }

    #[Test]
    public function the_component_is_rendered_with_a_logo_and_secondary_title(): void
    {
        Storage::fake('logos')
            ->put('logo.svg', file_get_contents(__DIR__ . '/../../fixtures/logo.svg'));

        /** @var Package $package */
        $package = Package::factory()->notVisible()->make();
        $package->logo = 'logo.svg';

        $this->component(PackageTitle::class, ['package' => $package, 'secondaryTitle' => 'Secondary Test'])
            ->assertSee('<h1 class="package-title__primary">' . $package->display_name . '</h1>', false)
            ->assertSee('<div class="package-title__logo">', false)
            ->assertSee('<h2 class="package-title__secondary">Secondary Test</h2>', false);
    }
}

<?php

namespace Tests\Unit\View;

use BabDev\View\Components\Hero;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class HeroComponentTest extends TestCase
{
    #[Test]
    public function the_component_is_rendered_with_only_a_title(): void
    {
        $this->component(Hero::class, ['title' => 'Test'])
            ->assertSee('<h1 class="hero__title">Test</h1>', false)
            ->assertDontSee('<h2 class="hero__subtitle">', false);
    }

    #[Test]
    public function the_component_is_rendered_with_a_title_and_subtitle(): void
    {
        $this->component(Hero::class, ['title' => 'Test', 'subtitle' => 'Second Test'])
            ->assertSee('<h1 class="hero__title">Test</h1>', false)
            ->assertSee('<h2 class="hero__subtitle">Second Test</h2>', false);
    }
}

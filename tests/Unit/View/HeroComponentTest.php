<?php

namespace Tests\Unit\View;

use BabDev\View\Components\Hero;
use Tests\TestCase;

final class HeroComponentTest extends TestCase
{
    /** @test */
    public function the_component_is_rendered_with_only_a_title()
    {
        $this->component(Hero::class, ['title' => 'Test'])
            ->assertSee('<h1 class="hero__title">Test</h1>', false)
            ->assertDontSee('<h2 class="hero__subtitle">', false);
    }

    /** @test */
    public function the_component_is_rendered_with_a_title_and_subtitle()
    {
        $this->component(Hero::class, ['title' => 'Test', 'subtitle' => 'Second Test'])
            ->assertSee('<h1 class="hero__title">Test</h1>', false)
            ->assertSee('<h2 class="hero__subtitle">Second Test</h2>', false);
    }
}

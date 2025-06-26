<?php

namespace Tests\Unit\View;

use App\View\Components\Hero;
use Tests\TestCase;

final class HeroComponentTest extends TestCase
{
    public function test_the_component_is_rendered_with_only_a_title(): void
    {
        $this->component(Hero::class, ['title' => 'Test'])
            ->assertSee('<h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-4xl">Test</h1>', false)
            ->assertDontSee('<h2 class="mt-6 text-lg leading-8 text-orange-100 sm:text-xl lg:text-2xl">', false);
    }

    public function test_the_component_is_rendered_with_a_title_and_subtitle(): void
    {
        $this->component(Hero::class, ['title' => 'Test', 'subtitle' => 'Second Test'])
            ->assertSee('<h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-4xl">Test</h1>', false)
            ->assertSee('<h2 class="mt-6 text-lg leading-8 text-orange-100 sm:text-xl lg:text-2xl">Second Test</h2>', false);
    }
}

<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    #[Test]
    public function users_can_visit_the_homepage(): void
    {
        $this->get('/')
            ->assertSee('<h1 class="hero__title">Creating Open Source Solutions Since 2010</h1>', false)
            ->assertViewIs('homepage');
    }
}

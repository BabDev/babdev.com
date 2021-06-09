<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SponsorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_view_the_sponsor_page(): void
    {
        $this->get('/sponsor')
            ->assertSee('<h1 class="hero__title">Sponsor Open Source Development</h1>', false)
            ->assertViewIs('sponsor');
    }
}

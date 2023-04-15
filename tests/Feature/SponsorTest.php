<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SponsorTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_view_the_sponsor_page(): void
    {
        $this->get('/sponsor')
            ->assertOk()
            ->assertSee('<h1 class="hero__title">Sponsor Open Source Development</h1>', false)
            ->assertViewIs('sponsor');
    }
}

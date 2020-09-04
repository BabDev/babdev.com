<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyTest extends TestCase
{
    /** @test */
    public function users_can_view_the_privacy_policy()
    {
        $this->get('/privacy')
            ->assertSee('<h1 class="hero__title">Site Privacy</h1>', false)
            ->assertViewIs('privacy');
    }
}

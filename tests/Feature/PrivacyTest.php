<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PrivacyTest extends TestCase
{
    #[Test]
    public function users_can_view_the_privacy_policy(): void
    {
        $this->get('/privacy')
            ->assertSee('<h1 class="hero__title">Site Privacy</h1>', false)
            ->assertViewIs('privacy');
    }
}

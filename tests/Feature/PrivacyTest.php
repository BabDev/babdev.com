<?php

namespace Tests\Feature;

use Tests\TestCase;

final class PrivacyTest extends TestCase
{
    public function test_users_can_view_the_privacy_policy(): void
    {
        $this->get('/privacy')
            ->assertOk()
            ->assertViewIs('privacy');
    }
}

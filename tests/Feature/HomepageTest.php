<?php

namespace Tests\Feature;

use Tests\TestCase;

final class HomepageTest extends TestCase
{
    public function test_users_can_visit_the_homepage(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('homepage');
    }
}

<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest;
use BabDev\GitHub\Actions\ContainerAwareFactory;
use Tests\TestCase;

class ContainerAwareFactoryTest extends TestCase
{
    /** @test */
    public function the_factory_resolves_an_action_class()
    {
        $factory = $this->app->make(ContainerAwareFactory::class);

        $this->assertInstanceOf(
            ClosePagerfantaReadOnlyRepoPullRequest::class,
            $factory->make(ClosePagerfantaReadOnlyRepoPullRequest::class)
        );
    }
}

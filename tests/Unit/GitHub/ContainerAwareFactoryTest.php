<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest;
use BabDev\GitHub\Actions\ContainerAwareFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContainerAwareFactoryTest extends TestCase
{
    #[Test]
    public function the_factory_resolves_an_action_class(): void
    {
        $factory = $this->app->make(ContainerAwareFactory::class);

        $this->assertInstanceOf(
            ClosePagerfantaReadOnlyRepoPullRequest::class,
            $factory->make(ClosePagerfantaReadOnlyRepoPullRequest::class),
        );
    }
}

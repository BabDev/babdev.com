<?php

namespace Tests\Unit\GitHub;

use App\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest;
use App\GitHub\Actions\ContainerAwareFactory;
use Tests\TestCase;

final class ContainerAwareFactoryTest extends TestCase
{
    public function test_the_factory_resolves_an_action_class(): void
    {
        $factory = $this->app->make(ContainerAwareFactory::class);

        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertInstanceOf(
            ClosePagerfantaReadOnlyRepoPullRequest::class,
            $factory->make(ClosePagerfantaReadOnlyRepoPullRequest::class),
        );
    }
}

<?php

namespace BabDev\GitHub\Actions;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\Actions\Factory;
use Illuminate\Contracts\Container\Container;

final class ContainerAwareFactory implements Factory
{
    public function __construct(private readonly Container $container)
    {
    }

    /**
     * @param class-string<TAction> $class
     *
     * @return TAction
     *
     * @template TAction of Action
     */
    public function make(string $class): Action
    {
        return $this->container->make($class);
    }
}

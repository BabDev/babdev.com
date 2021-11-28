<?php

namespace BabDev\GitHub\Actions;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\Actions\Factory;
use Illuminate\Contracts\Container\Container;

final class ContainerAwareFactory implements Factory
{
    public function __construct(private Container $container)
    {
    }

    /**
     * @param class-string<Action> $class
     */
    public function make(string $class): Action
    {
        return $this->container->make($class);
    }
}

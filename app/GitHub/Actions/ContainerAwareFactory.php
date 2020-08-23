<?php

namespace BabDev\GitHub\Actions;

use BabDev\Contracts\GitHub\Actions\Action;
use BabDev\Contracts\GitHub\Actions\Factory;
use Illuminate\Contracts\Container\Container;

final class ContainerAwareFactory implements Factory
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param class-string $class
     */
    public function make(string $class): Action
    {
        return $this->container->make($class);
    }
}

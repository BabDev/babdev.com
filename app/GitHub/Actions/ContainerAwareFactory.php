<?php

namespace App\GitHub\Actions;

use App\Contracts\GitHub\Actions\Action;
use App\Contracts\GitHub\Actions\Factory;
use Illuminate\Contracts\Container\Container;

final readonly class ContainerAwareFactory implements Factory
{
    public function __construct(private Container $container) {}

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

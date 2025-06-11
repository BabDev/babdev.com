<?php

namespace App\Contracts\GitHub\Actions;

interface Factory
{
    /**
     * @param class-string<TAction> $class
     *
     * @return TAction
     *
     * @template TAction of Action
     */
    public function make(string $class): Action;
}

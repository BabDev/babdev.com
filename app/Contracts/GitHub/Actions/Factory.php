<?php

namespace BabDev\Contracts\GitHub\Actions;

interface Factory
{
    /**
     * @param class-string<Action> $class
     */
    public function make(string $class): Action;
}

<?php

namespace BabDev\Contracts\GitHub\Actions;

interface Factory
{
    /**
     * @param class-string $class
     */
    public function make(string $class): Action;
}

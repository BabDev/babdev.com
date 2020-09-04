<?php

namespace BabDev\Contracts\GitHub;

interface JWTTokenGenerator
{
    public function generate(array $repoConfig): string;
}

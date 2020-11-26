<?php

namespace BabDev\Contracts\GitHub;

use Lcobucci\JWT\Configuration;

interface JWTConfigurationBuilder
{
    public function build(array $repoConfig): Configuration;
}

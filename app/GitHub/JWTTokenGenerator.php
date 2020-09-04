<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;

final class JWTTokenGenerator implements JWTTokenGeneratorContract
{
    public function generate(array $repoConfig): string
    {
        $token = (new Builder())
            ->issuedBy($repoConfig['app_id'])
            ->issuedAt(\time())
            ->expiresAt(\time() + 60)
            ->getToken(new Sha256(), new Key(\sprintf('file://%s', $repoConfig['key'])));

        return (string) $token;
    }
}

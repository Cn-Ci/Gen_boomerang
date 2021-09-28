<?php

namespace App\Controller\Mercure;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Component\HttpFoundation\Cookie;

class CookieGenerator {
    private $secret;

    public function __construct(string $secret){
        $this->secret = $secret;
    }

    public function generate():Cookie {
        $token = (new Builder())
            ->withClaim('mercure', ['subscribe' => ['*']])
            ->getToken(new Sha256(), new Key($this->secret));

        return Cookie::create('mercureAuthorization', $token, 0, '/.well-known/mercure');
    }
}
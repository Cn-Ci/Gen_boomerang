<?php 

namespace App\Controller\Mercure;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JwtProvider {
    private $secret;

    public function __construct(string $secret) {
        $this->secret = $secret;
    }

    public function __invoke():string {
        return (new Builder())
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken(new Sha256(), new Key($this->secret));
    }
}
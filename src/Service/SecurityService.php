<?php 

namespace App\Service;

use Symfony\Component\Security\Core\Security;

class SecurityService {
    private $secutiry;

    public function __construct(Security $security) {
        $this->secutiry = $security;
    }

    public function getUser() {
        return $this->secutiry->getUser();
    }
}
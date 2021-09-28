<?php

namespace App\Tests\Controller\traits;

use App\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait AuthenticateSimulatorTrait {
    public function createCookieForUser(User $user){
        $session =$this->client->getContainer()->get('session');
        $sessionToken = new UsernamePasswordToken($user, null, "main", $user->getRoles());
        $session->set("_security_main", serialize($sessionToken));
        $session->save();
        $cookie=new Cookie($session->getName(), $session->getId());
        return $cookie;
    }
}
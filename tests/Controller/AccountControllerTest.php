<?php

use App\DataFixtures\AppFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\Traits\AuthenticateSimulator;
use App\Tests\Controller\traits\AuthenticateSimulatorTrait;

class AccountControllerTest extends WebTestCase{

    use FixturesTrait;
    use AuthenticateSimulatorTrait;
        private $client;
    /**
     * prepares the test
     * @before
     * @return void 
     */ 
    protected function prepareTest(){
       
        $this ->client = static::createClient();
    }

    public function testRedirectedToLoginWhenNotAuthenticated(){
        $this-> client ->request('GET', '/inscription');

        $this->assertResponseIsSuccessful('login');

    }
    public function testRedirectedToLoginWhenAccessHomePageWithNoAuthentication(){
        $this-> client ->request('GET', '/home');

        $this->assertResponseIsSuccessful(Response::HTTP_OK);

    }
    public function testAccessToPersonnesRouteRouteWithAuth(){
        $this->loadFixtures([AppFixtures::class]);
        $user = self::$container->get(UserRepository::class)->find(1);
        // appel de la fonction présente dans AuthenticateSimualtorTrait
        
        $cookie = $this->createCookieForUser($user);
        $this->client->getCookieJar()->set($cookie);
        $this->client->request('GET', '/inscription');
        $this->assertResponseIsSuccessful();

    }
}
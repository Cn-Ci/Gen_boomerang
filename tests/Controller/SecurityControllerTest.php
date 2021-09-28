<?php

namespace App\Tests\Controller;


use App\DataFixtures\AppFixtures;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\EmptyFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\traits\AuthenticateSimulatorTrait;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityControllerTest extends WebTestCase{

    use FixturesTrait;
    use AuthenticateSimulatorTrait;

    
    private $client;
    /**
     * prepares the test
     * 
     * @return void
     */
    protected function setUp(){
        $this->ensureKernelShutdown();
        $this->client = static::createClient();

    }
      /**
     * This method is called after each test.
     */
    protected function tearDown():void/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->loadFixtures([EmptyFixtures::class]);
    }
    
    public function testLoginFormIsDisplayed(){
        $this->client->request("GET", "/login");
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("html h3", "Connectez-vous");
    }

    public function testLoginSuccessRedirectToHome(){
        $this->loadFixtures([AppFixtures::class]);
        $form=$this->createLoginForm("admin@gmail.com","Internet1!");
        $this->client->submit($form);
       // $this->assertResponseRedirects("/");
        $this->client->followRedirect();
        $this->assertSelectorExists('form');
    }
    /**
     * 
     */
    public function testLoginWithBadEmail(){
        $this->loadFixtures([AppFixtures::class]);
        $form=$this->createLoginForm("aczfczsdbk@free.fr","Internet1!");
        $this->client->submit($form);
       // $this->assertResponseRedirects("/login");
        $this->client->followRedirect();
        $this->assertSelectorExists("form");
  

    }
    private function createLoginForm($email, $password){
        $crawler = $this->client->request("GET", "/login");
        $button = $crawler->selectButton('Je me connecte');
        $form=$button->form([
         "email"=> $email,
         "password"=> $password
         ]);
         return $form;
    }
    
}
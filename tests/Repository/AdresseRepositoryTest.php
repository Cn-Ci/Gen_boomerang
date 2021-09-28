<?php

use App\DataFixtures\UserFixtures;
use App\Repository\AdresseRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdresseRepositoryTest extends WebTestCase{

    use FixturesTrait;


    /**
     * Prepares the tests
     * @before
     * @return void
     */

    public function setUp(){

        self::bootKernel();
    }     

    public function testFindAllReturnsAllAdresse(){
        $this->loadFixtures([UserFixtures::class]);
        $users = self::$container->get(AdresseRepository::class)->findAll();
        $this->assertCount(11, $users);
    }
}
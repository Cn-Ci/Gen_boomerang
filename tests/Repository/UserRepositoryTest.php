<?php

use App\Entity\User;
use App\Entity\Adresse;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase {

    use FixturesTrait;


    /**
     * Prepares the tests
     * @before
     * @return void
     */

    public function setUp(){

        self::bootKernel();
    }     

    public function testFindAllReturnsAllUsers(){
        $this->loadFixtures([UserFixtures::class]);
        $users = self::$container->get(UserRepository::class)->findAll();
        $this->assertCount(11, $users);
    }

    public function testFindById(){
        $this->loadFixtures([UserFixtures::class]);
        $users = self::$container->get(UserRepository::class)->find(1);
        $this->assertInstanceOf(User::class,$users);
        $this->assertEquals(1, $users->getId());
    }


    public function testInsertion(){
        $adresse =(new Adresse())->setNumeroRue("3")->setNomRue("Lisoire")->setCodePostal("59000")->setVille("Lille")->setRegion("Hauts de France");
        $user= (new User()) ->setEmail("david.dupond@gmail.com")   
                                ->setFirstName("david")
                                ->setLastName("dupond")
                                ->setPassword("Internet1!")
                                ->setVerifyPassword("Internet1!")
                                ->setFilename("imageTest.jpg")
                                ->setDescription("je suis un test")
                                ->setAdresse($adresse);
                                   
        $manager = self::$container ->get('doctrine.orm.entity_manager');
        $manager->persist($user);
        $manager->flush();
        $userTrouvee = self::$container->get(UserRepository::class)->find($user);

        $this->assertNotNull($userTrouvee);
        $this->assertEquals("david", $userTrouvee->getFirstName());

      
    }

  

    /**
     * stops the kernel
     * @after
     * @return void
     */

    public function closeTests(){
        self::ensureKernelShutdown();
        $this->loadFixtures([UserFixtures::class]);
        
    }


}
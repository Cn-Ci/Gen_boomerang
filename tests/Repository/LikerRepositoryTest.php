<?php

use App\Entity\User;
use App\Entity\Liker;
use App\Entity\Adresse;
use App\Entity\Articles;
use App\DataFixtures\AppFixtures;
use App\Repository\LikerRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LikerRepositoryTest extends WebTestCase{
    use FixturesTrait;

    /**
     * Prepares the tests
     * @before
     * @return void
     */

    public function setUp(){

        self::bootKernel();
    }
    
    public function testFindAllReturnsAllLikes(){
        $this->loadFixtures([AppFixtures::class]);
        $liker = self::$container->get(LikerRepository::class)->findAll();
        $this->assertCount(90, $liker);
    }

    public function testFindById(){
        $this->loadFixtures([AppFixtures::class]);
        $users = self::$container->get(LikerRepository::class)->find(1);
        $this->assertInstanceOf(Liker::class,$users);
        $this->assertEquals(1, $users->getId());
    }


    // public function testInsertion(){
        
    //     $adresse =(new Adresse())->setNumeroRue("3")->setNomRue("Lisoire")->setCodePostal("59000")->setVille("Lille")->setRegion("Hauts de France");
    //     $user= (new User()) ->setEmail("david.dupond@gmail.com")   
    //                         ->setFirstName("david")
    //                         ->setLastName("dupond")
    //                         ->setPassword("Internet1!")
    //                         ->setVerifyPassword("Internet1!")
    //                         ->setFilename("imageTest.jpg")
    //                         ->setDescription("je suis un test")
    //                         ->setAdresse($adresse);

    //     $article =(new Articles())  ->setTitreArticle("voici le titre de l'article test")
    //                                 ->setContenuArticle("voici le contenu de l'article en test")
    //                                 ->setFilename("imageTest.jpg")
    //                                 ->setCreatedAt(new \DateTime('2020-06-22'))
    //                                 ->setUpdatedAt(new \DateTime('2020-06-22'))
    //                                 ->setVideo("https://youtu.be/6h7YL9mfojU");

    //     $liker =(new Liker())   ->setArticle($article)
    //                             ->setUser($user);
                                
                                
    //     $manager = self::$container->get('doctrine.orm.entity_manager');
    //     $manager->persist($user);
    //     $manager->persist($article);
    //     $manager->persist($liker);
    //     $manager->flush();
    //     $likerTrouvee = self::$container->get(likerRepository::class)->find($liker);

    //     $this->assertNotNull($likerTrouvee);
    //     $this->assertEquals("test content", $likerTrouvee->getContenu());
    // }



}
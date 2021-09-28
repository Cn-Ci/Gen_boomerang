<?php

use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Articles;
use App\Entity\Commentaires;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\EmptyFixtures;
use App\DataFixtures\ArticlesFixtures;
use App\DataFixtures\CommentairesFixtures;
use App\Repository\CommentairesRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentaireRepositoryTest extends WebTestCase {

    use FixturesTrait;

    /**
     * Prepares the tests
     * @before
     * @return void
     */

    public function setUp(){

        self::bootKernel();
    }     

    public function testFindAllReturnsAllComments(){
        $this->loadFixtures([AppFixtures::class]);
        $commentaires = self::$container->get(CommentairesRepository::class)->findAll();
        $this->assertCount(90, $commentaires);
    }

    public function testFindById(){
        $this->loadFixtures([AppFixtures::class]);
        $users = self::$container->get(CommentairesRepository::class)->find(1);
        $this->assertInstanceOf(Commentaires::class,$users);
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

        $article =(new Articles())  ->setTitreArticle("voici le titre de l'article test")
                                    ->setContenuArticle("voici le contenu de l'article en test")
                                    ->setFilename("imageTest.jpg")
                                    ->setCreatedAt(new \DateTime('2020-06-22'))
                                    ->setUpdatedAt(new \DateTime('2020-06-22'))
                                    ->setVideo("https://youtu.be/6h7YL9mfojU");

        $commentaire =(new Commentaires())  ->setContenu("test content")
                                            ->setArticle($article)
                                            ->setActif(1)
                                            ->setRgpd(1)
                                            ->setCreatedAt(new \DateTime('2020-06-22'))
                                            ->setUser($user);
                                
                                
        $manager = self::$container->get('doctrine.orm.entity_manager');
        $manager->persist($user);
        $manager->persist($article);
        $manager->persist($commentaire);
        $manager->flush();
        $commentaireTrouvee = self::$container->get(CommentairesRepository::class)->find($commentaire);

        $this->assertNotNull($commentaireTrouvee);
        $this->assertEquals("test content", $commentaireTrouvee->getContenu());
    }

    /**
     * stops the kernel
     * @after
     * @return void
     */

    public function closeTests(){
        self::ensureKernelShutdown();
        $this->loadFixtures([EmptyFixtures::class]);
        
    }
    
}
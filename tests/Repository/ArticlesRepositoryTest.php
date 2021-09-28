<?php

use App\DataFixtures\ArticlesFixtures;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticlesRepositoryTest extends WebTestCase{

    use FixturesTrait;

    /**
     * Prepares the tests
     * @before
     * @return void
     */

    public function setUp(){
        self::bootKernel();
    }

    public function testFindAllReturnsAllArticles(){
        $this->loadFixtures([ArticlesFixtures::class]);
        $articles = self::$container->get(ArticlesRepository::class)->findAll();
        $this->assertCount(29, $articles);
    }
    
    public function testFindById(){
        $this->loadFixtures([ArticlesFixtures::class]);
        $articles = self::$container->get(ArticlesRepository::class)->find(1);
        $this->assertInstanceOf(Articles::class,$articles);
        $this->assertEquals(1, $articles->getId());
    }

    public function testInsertion(){
        $article= (new Articles()) ->setTitreArticle("voici le titre de l'article test")
                                   ->setContenuArticle("voicile contenu de l'article en test")
                                   ->setFilename("imageTest.jpg")
                                   ->setCreatedAt(new \DateTime('2020-06-22'))
                                   ->setUpdatedAt(new \DateTime('2020-06-22'))
                                   ->setVideo("https://youtu.be/6h7YL9mfojU");
                                   
        $manager = self::$container ->get('doctrine.orm.entity_manager');
        $manager->persist($article);
        $manager->flush();
        $articleTrouvee = self::$container->get(ArticlesRepository::class)->find($article);

        $this->assertNotNull($articleTrouvee);
        $this->assertEquals("voici le titre de l'article test", $articleTrouvee->getTitreArticle());
    }

    public function testArticlesSearch(){
        $articles = self::$container->get(ArticlesRepository::class)->search('um');
        $this->assertContains('um', $articles[0]->getTitreArticle());
    }

    /**
     * stops the kernel
     * @after
     * @return void
     */

    public function closeTests(){
        self::ensureKernelShutdown();
        $this->loadFixtures([ArticlesFixtures::class]);
        
    }

}
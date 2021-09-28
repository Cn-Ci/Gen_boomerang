<?php
namespace App\Tests\Controller;

use App\Entity\Articles;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use App\DataFixtures\EmptyFixtures;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\traits\AuthenticateSimulatorTrait;

class ArticlesControllerTest extends WebTestCase{

    use FixturesTrait;
    use AuthenticateSimulatorTrait;

    
     private $client;

    private function createLoginForm($email, $password){
        $crawler = $this->client->request("GET", "/login");
        $button = $crawler->selectButton('Je me connecte');
        $form=$button->form([
         "email"=> $email,
         "password"=> $password
         ]);
         return $form;
    } 

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

    public function testShowArticlesIndex(){
        
        $this->client->request('GET', '/articles/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorTextContains('html h1', 'Articles de notre communauté');
    }

    public function testShowArticlesnew(){

        $this->loadFixtures([AppFixtures::class]);
        $form=$this->createLoginForm("admin2@gmail.com","Internet1!");
        
        $this->client->submit($form);

        // test e.g. the articles new page
        $this->client->request('GET', '/articles/new');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créer un nouvel article');
    }

    // public function testShowArticlesEdit(){

        
    //         $articles = new Articles();
    //         $articles->setFilename("filename");        
    //         $articles->setTitreArticle("Titre");
    //         $articles->setContenuArticle("contenu");
    //         $articles->setCreatedAt(new \DateTime('2020-06-22'));
    //         $articles->setUpdatedAt(new \DateTime('2020-06-22'));
    //         $articles->setSlug("slug");        
    //         $articles->setVideo("http://placehold.it/350x250");

    //         $manager = self::$container ->get('doctrine.orm.entity_manager');
    //         $manager->persist($articles);
    //         $manager->flush();


    //     $this->loadFixtures([UserFixtures::class]);
    //     $form=$this->createLoginForm("admin@gmail.com","Internet1!");
        
    //     $this->client->submit($form);
        
    //     $this->client->request('GET', '/articles/slug/edit');
    //     $this->assertResponseIsSuccessful();
    //     $this->assertSelectorTextContains('h1', 'Modification de l\'article');

    // }

  
}
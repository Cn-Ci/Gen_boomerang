<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Liker;
use App\Entity\Articles;
use App\Entity\Commentaires;
use Symfony\Component\Validor\Constraints\NotNull;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ArticlesTest extends KernelTestCase {

    private function createUser(){
        $user = new User();
        $user->setFirstName("Leclercq");                        
        $user->setLastName("Jerome");
        $user->setFileName("pm1-SFgppK.jpg");
        $user->setDescription("une Description");
        $user->setEmail("admin@gmail.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword("Test123456+");
        return $user;       
    }

    public function createCommentaire(){
        $commentaire = new Commentaires();
        $commentaire->setContenu("contenu");
        $commentaire->setActif(true);
        $commentaire->setCreatedAt(new \DateTime('2020-12-01'));
        return $commentaire;
    }

    public function createCommentaireVide(){
        $commentaire = new Commentaires();
        
        return $commentaire;
    }

    public function createLikerVide(){
        $liker = new Liker();
        
        return $liker;
    }

    private function createArticle(){
        $articles = new Articles();
        $articles->setFilename("filename");        
        $articles->setTitreArticle("Titre");
        $articles->setContenuArticle("contenu");
        $articles->setCreatedAt(new \DateTime('2020-06-22'));
        $articles->setUpdatedAt(new \DateTime('2020-06-22'));
        $articles->setSlug("slug");        
        $articles->setVideo("http://placehold.it/350x250");
        $articles->setAuthor($this->createUser());
        $articles->addCommentaire($this->createCommentaire());
        $articles->addLiker($this->createLikerVide());
        
        return $articles;
    }
    

    private function expectXErrorsForArticle(int $nbrErrors, Articles $articles){
        $errors = self::$container->get("validator")->validate($articles);
        $this->assertCount($nbrErrors, $errors);
    }

    public function testSiArticleValide(){
        self::bootKernel();
        $articles = $this->createArticle();
        $this->expectXErrorsForArticle(0, $articles);
    }


//  Test sur Filename
    public function testStringFilename(){
        $articles = $this->createArticle();
        $this->assertIsString($articles->getFilename());                    
    }

    public function testSiFilenameInferieurA5(){
        self::bootKernel();
        $articles = $this->createArticle()->setFilename("xxxx");
        $this->expectXErrorsForArticle(1, $articles);
    }
// test sur l'imageFile

    public function testIfImageFileIsAGoodExtension(){
        self::bootKernel();
        $articles = $this->createArticle()->setImageFile("/public/images/user/1efqCuh_NI.jpg");
        $this->expectXErrorsForArticle(1, $articles);
    }

//  Test sur Titre de l'Article
    public function testStringTitreArticle(){
        $articles = $this->createArticle();
        $this->assertIsString($articles->getTitreArticle());                    
    }

    public function testSiTitreArticleSupOuEgalA5(){
        self::bootKernel();
        $articles = $this->createArticle()->setTitreArticle("xxxxx");
        $this->expectXErrorsForArticle(0, $articles);
    }

    public function testSiTitreArticleInfA5(){
        self::bootKernel();
        $articles = $this->createArticle()->setTitreArticle("xxxx");
        $this->expectXErrorsForArticle(1, $articles);
    }

    public function testSiTitreArticleInfInfA50(){
        self::bootKernel();
        $articles = $this->createArticle()->setTitreArticle("01234567890123456789012345678901234567890123456789");
        $this->expectXErrorsForArticle(0, $articles);
    }

    public function testSiTitreArticleInfSupA255(){
        self::bootKernel();
        $articles = $this->createArticle()->setTitreArticle("101234567890123456789012345678901234567890123456789101234567890123456789012345678901234567890123456789101234567890123456789012345678901234567890123456789101234567890123456789012345678901234567890123456789101234567890123456789012345678901234567890123456789101234567890123456789012345678901234567890123456789101234567890123456789012345678901234567890123456789");
        $this->expectXErrorsForArticle(1, $articles);
    }

//  Test sur Contenu de l'Article
    public function testStringContenuArticle(){
        $articles = $this->createArticle();
        $this->assertIsString($articles->getContenuArticle());                    
    }

    public function testSiTitreContenuSupOuEgalA50(){ //50 carateres
        self::bootKernel();
        $articles = $this->createArticle()->setContenuArticle("01234567890123456789012345678901234567890123456789");
        $this->expectXErrorsForArticle(0, $articles);
    }

    public function testSiContenuArticleInfA50(){  //49 carateres
        self::bootKernel();
        $articles = $this->createArticle()->setContenuArticle("1234");
        $this->expectXErrorsForArticle(1, $articles);
    }
    
//  Test sur Date de creation et d'update
    public function testDatePresente(){
        $articles = $this->createArticle();
        $this->assertEquals(new \DateTime('2020-06-22'),$articles->getCreatedAt());                    
    }

    public function testUpdatePresente(){
        $articles = $this->createArticle();
        $this->assertEquals(new \DateTime('2020-06-22'),$articles->getUpdatedAt());                    
    }

//  Test sur Slug
    public function testStringSlug(){
        $articles = $this->createArticle();
        $this->assertIsString($articles->getSlug());                    
    }   

//  Test sur Video
    public function testStringVideo(){
        $articles = $this->createArticle();
        $this->assertIsString($articles->getVideo());                    
} 

//  Test sur Commentaires
    public function testStringCommentaires(){
        $article = $this->createArticle();
        $collection =  $this->createCommentaire(); 
        $collectionVide = $this->createCommentaireVide();    
        $this->assertEquals($collection->getContenu(), 'contenu');  
        $this->assertIsObject($article->getCommentaires($collection));  
    } 
// test sur Author
    public function testAuthor(){
        $articles = $this->createArticle();
        $this->assertNotEmpty($articles->getAuthor());                    
    }       

    // test like dans User //

    public function testLike(){
        $article = $this->createArticle();
        $this->assertNotEmpty($article->getLikers());  
    }

      
    
}
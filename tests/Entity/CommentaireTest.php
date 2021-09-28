<?php
namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Liker;
use App\Entity\Articles;
use App\Entity\Commentaires;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentaireTest extends KernelTestCase{

    private function createCommentaires(){
        $commentaire = new Commentaires();
        $commentaire ->setContenu("test sur le contenu");
        $commentaire ->setCreatedAt(new \DateTime('2020-06-22'));
        $commentaire ->setActif(1);
        $commentaire ->setArticle($this->createArticles());
        $commentaire ->setUser($this->createUser());
        return $commentaire;
    }

    private function createArticles(){
        $articles = new Articles();
        $articles->setFilename("filename");        
        $articles->setTitreArticle("Titre");
        $articles->setContenuArticle("contenu");
        $articles->setCreatedAt(new \DateTime('2020-06-22'));
        $articles->setUpdatedAt(new \DateTime('2020-06-22'));
        $articles->setSlug("slug");        
        $articles->setVideo("http://placehold.it/350x250");

        return $articles;
        
    }

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

    public function testArticles(){
        $commentaires = $this->createCommentaires();
        $this->assertNotEmpty($commentaires->getArticle());  
    }

    public function testUser(){
        $commentaires = $this->createCommentaires();
        $this->assertNotEmpty($commentaires->getUser());  
    }

    public function testDatePresente(){
        $commentaires = $this->createCommentaires();
        $this->assertEquals(new \DateTime('2020-06-22'),$commentaires->getCreatedAt());                    
    }

    public function testActif(){
        $commentaires = $this->createCommentaires();
        $this->assertIsBool($commentaires->getActif(1));

    }

}
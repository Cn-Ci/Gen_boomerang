<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Liker;
use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LikerTest extends KernelTestCase{

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

    public function createLiker(){
        $liker = new Liker();
        $liker ->setUser($this->createUser());
        $liker ->setArticle($this->createArticles());
        return $liker;
    }

    public function testUser(){
        $liker = $this->createLiker();
        $this->assertNotEmpty($liker->getUser());
    }

    public function testArticle(){
        $liker = $this->createLiker();
        $this->assertNotEmpty($liker->getArticle());
    }

}
<?php
namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Liker;
use App\Entity\Adresse;
use App\Entity\Articles;
use App\Entity\Commentaires;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase{

    private function createAdresse(){
        $adresse = new Adresse();
        $adresse ->setNumeroRue("10");
        $adresse ->setNomRue("rueduhavre");
        $adresse ->setCodePostal(59200);
        $adresse ->setVille("Tourcoing");
        $adresse ->setRegion("Nord");  
           
        return $adresse;
       
    }

    private function createCommentaires(){
        $commentaire = new Commentaires();
        $commentaire ->setContenu("test sur le contenu");

        return $commentaire;
    }

    public function createLikerVide(){
        $liker = new Liker();
        
        return $liker;
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
        $user->setEmail("admin@gmail.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword("Test123456!");
        $user->setVerifyPassword("Test123456!");
        $user->setFirstName("Leclercq");                        
        $user->setLastName("Jerome");
        $user->setFileName("pm1-SFgppK.jpg");
        // $user->setImageFile("/public/images/avatarVide.jpg");
        $user->setDescription("une Description");
        $user->setAdresse($this->createAdresse());
        $user->AddCommentaire($this->createCommentaires());
        $user->addArticle($this->createArticles());
        $user->addLiker($this->createLikerVide());
        return $user;      
    }

    private function expectXErrorsForUser(int $nbrErrors, User $users){
        $errors = self::$container->get("validator")->validate($users);
        $this->assertCount($nbrErrors, $errors);
    }


    public function testIfUserValid(){
        self::bootKernel();
        $user= $this->createUser();
        $this->expectXErrorsForUser(0, $user);

    }
    // verification email
    public function testIfEmailIsCorrect(){
        self::bootKernel();
        $user = $this->createUser()->setEmail("12345678.email.com");
        $this->expectXErrorsForUser(1, $user);
    }

    public function testEmail(){
        $user = $this->createUser();
        $this->assertIsString($user->getEmail());        
    }

    // verification roles

    public function testRole(){
        $user = $this->createUser();
        $this->assertIsArray($user->getRoles());  
    }

    // verification Username

    public function testUsername(){
        $user = $this->createUser();
        $this->assertIsString($user->getUsername()); 
    }

    // verification du mot de passe
    public function testIfPasswordHasOnlyNumbers(){
        self::bootKernel();
        $user = $this->createUser()->setPassword("12345678");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfPasswordHasOnlyletters(){
        self::bootKernel();
        $user = $this->createUser()->setPassword("azertyuiop");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfPasswordhasSpecialCaracters(){
        self::bootKernel();
        $user = $this->createUser()->setPassword("Azerty123");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfpasswordHasUpperCase(){
        self::bootKernel();
        $user = $this->createUser()->setPassword("Azerty123");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfPasswordLasLessThan8(){
        self::bootKernel();
        $user = $this->createUser()->setPassword("Azert1!");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfPasswordHasMorethan24(){
        self::bootKernel();
        $user = $this->createUser()->setPassword("Azerty!01234567890123456789");
        $this->expectXErrorsForUser(1, $user);
    }

    public function testPassword(){
        $user = $this->createUser();
        $this->assertIsString($user->getPassword());        
    }
    // Verification du verifyPassword

    public function testConfirmPassword(){
        $user = $this->createUser();
        $this->assertIsString($user->getVerifyPassword());
    }

    // verification du prénom


    // public function testIfFirstNameisNotBlanck(){
    //     self::bootKernel();
    //     $user = $this->createUser()->setFirstName("");
    //     $this->expectXErrorsForUser(1, $user);
    // }
  
    public function tesIffirstNameisLessThan2(){
        self::bootKernel();
        $user = $this->createUser()->setFirstName("i");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfFirstNameIsMoreThan50(){
        self::bootKernel();
        $user = $this->createUser()->setFirstName("Axxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testFirstName(){
        $user = $this->createUser();
        $this->assertIsString($user->getFirstName());        
    }

    // vérification du nom
    public function tesIfLastNameisLessThan2(){
        self::bootKernel();
        $user = $this->createUser()->setLastName("i");
        $this->expectXErrorsForUser(1, $user);
    }
    public function testIfLasttNameIsMoreThan50(){
        self::bootKernel();
        $user = $this->createUser()->setLastName("Axxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
        $this->expectXErrorsForUser(1, $user);
    }

    public function testLastName(){
        $user = $this->createUser();
        $this->assertIsString($user->getLastName());        
    }

    // vérification de la description

    public function testIfDescriptionIsLessThan10(){
        self::bootKernel();
        $user = $this->createUser()->setDescription("123456789");
        $this->expectXErrorsForUser(1, $user);
    }

    public function testDescription(){
        $user = $this->createUser();
        $this->assertIsString($user->getDescription());        
    }

    //vérification du fileName

    public function testSiFilenameInferieurA5(){
        self::bootKernel();
        $user = $this->createUser()->setFilename("xxxx");
        $this->expectXErrorsForUser(1, $user);
    }

    public function testFilename(){
        $user = $this->createUser();
        $this->assertIsString($user->getFilename());        
    }

    // vérification imagefile

    public function testIfImageFileIsAGoodExtension(){
        self::bootKernel();
        $user = $this->createUser()->setImageFile("/public/images/avatarVide.jpg");
        
        $this->expectXErrorsForUser(1, $user);
    }

    // public function testImageFile(){
    //     $user = $this->createUser();
    //     $this->assertIsString($user->getImageFile());  
        
    // }
     

    // Test Adresse dans User  // 

    public function testdSiAdressePresente(){
        $user = $this->createUser();
        $this->assertNotEmpty($user->getAdresse());
        
    }
    // Test commentaires dans User //

    public function testCommentaires(){
        $user = $this->createUser();
        $this->assertNotEmpty($user->getCommentaires());  
    }

    // test articles dans User //
    public function testArticles(){
        $user = $this->createUser();
        $this->assertNotEmpty($user->getArticles());  
    }


    // test like dans User //

    public function testLike(){
        $user = $this->createUser();
        $this->assertNotEmpty($user->getLikers());  
    }
    






}
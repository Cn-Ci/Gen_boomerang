<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Adresse;
use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\NotNull;

class AdresseTest extends KernelTestCase {

    private function createUser(){
        $user = new User();
        $user->setFirstName("Leclercq");                        
        $user->setLastName("Jerome");
        // $user->setPicture("http://placehold.it/350x250");
        $user->setDescription("une Description");
        $user->setEmail("admin@gmail.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword("Test123456+");
        return $user;       
    }

    private function createAdresse(){
        $adresse = new Adresse();
        $adresse ->setNumeroRue("10");
        $adresse ->setNomRue("rueduhavre");
        $adresse ->setCodePostal(59200);
        $adresse ->setVille("Tourcoing");
        $adresse ->setRegion("Nord");
        $adresse ->addUser($this->createUser());   
           
        return $adresse;
       
    }

    

    private function expectXErrorsForAdresse(int $nbrErrors, Adresse $adresses){
        $errors = self::$container->get("validator")->validate($adresses);
        $this->assertCount($nbrErrors, $errors);
    }

    public function testSiAdresseValide(){
        self::bootKernel();
        $adresse = $this->createAdresse();
        $this->expectXErrorsForAdresse(0, $adresse);
    }


//  Verification sur le Numéro de rue
    public function testSiNumeroRueSuperieurA10Nombres(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setNumeroRue("12345678901");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testdNumeroRueAdresse(){
        $adresse = $this->createAdresse();
        $this->assertIsString($adresse->getNumeroRue()); 
                       
    }
//  Verification sur le Nom de rue
    public function testSiNomRueInferieurA3(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setNomRue("xx");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testdNomRueAdresse(){
        $adresse = $this->createAdresse();
        $this->assertIsString($adresse->getNomRue());        
    }

    public function testSiNomRueSuperieurA3(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setNomRue("xxx");
        $this->expectXErrorsForAdresse(0, $adresse);
    }

    public function testSiNomRueSuperieurA50(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setNomRue("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
        $this->expectXErrorsForAdresse(1, $adresse);
    }
// Verification sur le code postal

    public function testdCodePostaleAdresse(){
        $adresse = $this->createAdresse();
        $this->assertIsString($adresse->getCodePostal());   
        $this->assertLessThanOrEqual(99999, $adresse->getCodePostal());         
}

    public function testSiCodePostaleInferieurA5(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setCodePostal("1234");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testSiCodePostaleSuperieurA5(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setCodePostal("123456");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testSiCodePostaleEgaleA5(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setCodePostal("12345");
        $this->expectXErrorsForAdresse(0, $adresse);
    }
// Verification sur le nom de ville

    public function testdNomVilleAdresse(){
        $adresse = $this->createAdresse();
        $this->assertIsString($adresse->getVille());   
    }
    

    public function testSiNomDeVilleInferieurA2(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setVille("1");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testSiNomDeVilleSuperieurrA2(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setVille("123");
        $this->expectXErrorsForAdresse(0, $adresse);
    }

    public function testSiNomDeVilleSuperieurA50(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setVille("123456789012345678901234567890123456789012345678901");
        $this->expectXErrorsForAdresse(1, $adresse);
    }
// Verification sur la Région

    public function testdRegionAdresse(){
        $adresse = $this->createAdresse();
        $this->assertIsString($adresse->getRegion());   
    }

    public function testSiNomRegionSuperieurA50(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setRegion("123456789012345678901234567890123456789012345678901");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testSiNomRegionInferieurA2(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setRegion("1");
        $this->expectXErrorsForAdresse(1, $adresse);
    }

    public function testSiNomRegionSuperieurA2(){
        self::bootKernel();
        $adresse = $this->createAdresse()->setRegion("123");
        $this->expectXErrorsForAdresse(0, $adresse);
    }


    // Test User dans Adresse  // 

    public function testdSiUserPresent(){
        $adresse = $this->createAdresse();
        $this->assertNotEmpty($adresse->getUsers());
        
    }
    
}
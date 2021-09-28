<?php
namespace App\DataFixtures;

use Faker;
use App\Entity\Pole;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Liker;
use App\Entity\Images;
use App\Entity\Adresse;
use App\Entity\Message;
use App\Entity\Salarie;
use App\Entity\Annonces;
use App\Entity\Articles;
use App\Entity\Document;
use App\Entity\Etudiant;
use App\Entity\Retraite;
use App\Entity\RetourExp;
use App\Entity\Abonnement;
use App\Entity\Entreprise;
use App\Entity\Newsletter;
use App\Entity\SansEmploi;
use App\Entity\Commentaire;
use App\Entity\FaQuestions;
use App\Entity\Participant;
use App\Entity\AnnoncePoste;
use App\Entity\Commentaires;
use App\Entity\Conversation;
use App\Entity\Entrepreneur;
use App\Entity\OffreAbonnement;
use App\Entity\SecteurActivite;
use App\Entity\ChangerDeVieInfos;
use App\Entity\ProfessionLiberale;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture {
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    //* Fixture en commentaire avec relation non generer avec table non null
    //* Setter en commentaire pour voir tous les setters de l'entity 

    public function load(ObjectManager $manager) {
        /** Utilisation de faker pour generer des fausses données */
        $faker = Faker\Factory::create('fr_FR');

        //* Variable reutilisé pour faker
        $createdAt = $faker->dateTimeBetween('-3 months');
        $updatedAt = $faker->dateTimeBetween('-2 months');
        $date      = $faker->dateTimeBetween('-10 years');

        /******************** Adresse des Types d'User ******************/
        //* creation tableau vide 
        $adresses =[];

        for($i = 1 ; $i <= 20 ; $i++){
            $adresse = new Adresse();

            $adresse    
                ->setNumeroRue($faker->buildingNumber())
                ->setNomrue($faker->streetName())
                ->setCodePostal($faker->buildingNumber())
                ->setVille($faker->city())
                ->setRegion($faker->country())
            ;

            $manager-> persist($adresse);

            //* contenue de $adresse dans le tableau pour attribuer à chaque type
            $adresses[]=$adresse;
        }

        /******************** Abonnement des Types d'User ******************/
        //* creation tableau vide 
        $abonnements = [];

        for($i = 1 ; $i <= 5 ; $i++){
            $lesPrix = [9.99 , 49.99, 0, 59.99];
            $price   = $faker->randomElement($lesPrix);

            $abos    = ['pack étudiant', 'pack actif et retraité', 'pack solidaire', 'Demandeur demploi', 'entreprise'];
            $abo     = $faker->randomElement($abos);

            $status  = $faker->dateTimeBetween($startDate = '-1 day', $endDate = '+6 months', $timezone = null);

            $abonnement = new Abonnement();
            $abonnement 
                ->setTitle($abo)
                ->setPrice($price)  
                ->setDescription($faker->sentence())      
                ->setCreatedAt($createdAt)         
                ->setStatus($status)
            ;
            
            $manager-> persist($abonnement);

            //* contenue de $adresse dans le tableau pour attribuer à chaque type
            $abonnements[]=$abonnement;
        }    
        

        /******************** Entreprise des Types d'User Entrepreneur ******************/
        //* creation tableau vide 
        $entreprises = [];

        for($i = 1 ; $i <= 5 ; $i++){
            $entreprise = new Entreprise();

            $adresseId = $faker->randomElement($adresses);

            $entreprise 
                ->setNom("Ambulance de France $i")
                ->setActivite($faker->word())
            ;

            $manager-> persist($entreprise);
            //* contenue de $entreprise dans le tableau pour attribuer à chaque type
            $entreprises[]=$entreprise;
        } 
        
        /******************** User User ******************/
        $genre = ['madame', 'monsieur'];

        /****** User Retraite ******/
        for($i = 1 ; $i <= 2 ; $i++){
            $userRetraite = new Retraite();
        
            $hash     = $this->encoder->encodePassword($userRetraite, '123456');
            $civilite = $faker->randomElement($genre); 
            
            $userRetraite   
                ->setUpdatedAt($updatedAt)
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($hash)
                ->setFirstName($faker->firstName())                        
                ->setLastName($faker->lastname(null))
                ->setCivilite($civilite)
                ->setBirthdate($date)
                ->setDescription($faker->text())
                ->setPrecedentJobs("Ambulancier $i")
            ;

            $manager-> persist($userRetraite);
        } 

        /****** User Salarie ******/
        for($i = 1 ; $i <= 2 ; $i++){
            $userSalarie = new Salarie(); 
            
            $hash= $this->encoder->encodePassword($userSalarie, '123456');
     
            $userSalarie    
                ->setUpdatedAt($updatedAt)
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($hash)
                ->setFirstName($faker->firstName())                        
                ->setLastName($faker->lastname(null))
                ->setCivilite($civilite)
                ->setBirthdate($date)
                ->setDescription($faker->text())
                ->setCurrentJob("Pompier $i")
                ->setCompanyName("SDIS Roubaix $i")
            ;

            $manager-> persist($userSalarie);
        }

        /****** User SansEmploi ******/
        for($i = 1 ; $i <= 2 ; $i++){
            $userSansEmploi = new SansEmploi(); 
            
            $hash= $this->encoder->encodePassword($userSansEmploi, '123456');
     
            $userSansEmploi 
                ->setUpdatedAt($updatedAt)
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($hash)
                ->setFirstName($faker->firstName())                        
                ->setLastName($faker->lastname(null))
                ->setCivilite($civilite)
                ->setBirthdate($date)
                ->setDescription($faker->text())
                ->setSearchedJob("Peintre")
            ;

            $manager-> persist($userSansEmploi);
        }

        /****** User Etudiant ******/
        for($i = 1 ; $i <= 2 ; $i++){
            $userEtudiant = new Etudiant(); 
            
            $hash = $this->encoder->encodePassword($userEtudiant, '123456');
     
            $userEtudiant   
                ->setUpdatedAt($updatedAt)
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($hash)
                ->setFirstName($faker->firstName())                        
                ->setLastName($faker->lastname(null))
                ->setCivilite($civilite)
                ->setBirthdate($date)
                ->setDescription($faker->text())
                ->setSchoolName("Harvard")
                ->setLvlOfStudies("BAC + 4")
                ->setDomainStudies("Scientifique")
            ;

            $manager-> persist($userEtudiant);
        }

        /****** User Entrepreneur ******/
        for($i = 1 ; $i <= 2 ; $i++){
            $userEntrepreneur = new Entrepreneur(); 

            $hash = $this->encoder->encodePassword($userEntrepreneur, '123456');

            $userEntrepreneur   
                ->setUpdatedAt($updatedAt)
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($hash)
                ->setFirstName($faker->firstName())                        
                ->setLastName($faker->lastname(null))
                ->setCivilite($civilite)
                ->setBirthdate($date)
                ->setDescription($faker->text())
            ;

            $manager-> persist($userEntrepreneur);
        }

         /****** User Profession Liberal ******/
         for($i = 1 ; $i <= 2 ; $i++){
            $userProfessionLiberale = new ProfessionLiberale(); 

            $hash = $this->encoder->encodePassword($userProfessionLiberale, '123456');
         
            $userProfessionLiberale 
                ->setUpdatedAt($updatedAt)
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($hash)
                ->setFirstName($faker->firstName())                        
                ->setLastName($faker->lastname(null))
                ->setCivilite($civilite)
                ->setDescription($faker->text())
                ->setBirthdate($date)
                ->setCurrentJob("Prestataire $i")
            ;

            $manager-> persist($userProfessionLiberale);
        }

        /******************** User Admin ******************/
        $types     = [new Retraite(), new Entrepreneur(), new Etudiant(), new Salarie(), new SansEmploi(), new ProfessionLiberale()];
        $type      = $types[mt_rand(0, count($types) -1 )];
        $userAdmin = $type;
       
        $hash         = $this->encoder->encodePassword($userAdmin,'Internet1!');
        $adresseId    = $faker->randomElement($adresses);
        $abonnementId = $faker->randomElement($abonnements);

        $userAdmin     
            ->setUpdatedAt($updatedAt)
            ->setEmail("admin@gmail.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($hash)
            ->setFirstName("Admin")     
            ->setIsVerified(true)                   
            ->setLastName("Administrateur")                             
            ->setCivilite($civilite)
            ->setBirthdate($date)
            ->setDescription($faker->text())
            ->setAbonnement($abonnementId)
        ;

        if ($type instanceof Retraite){
            $userAdmin->setPrecedentJobs("Avocat");
        }
        if ($type instanceof Salarie){
            $userAdmin  
                ->setCurrentJob("Developpeur") 
                ->setCompanyName("Amazon")
            ;
        }
        if ($type instanceof SansEmploi){
            $userAdmin ->setSearchedJob("Physicien");
        }
        if ($type instanceof Etudiant){
            $userAdmin  
                ->setSchoolName("Oxford")
                ->setLvlOfStudies("BAC + 8")
                ->setDomainStudies("Ingénieur")
            ;
        }
        if ($type instanceof Entrepreneur){
            $userAdmin->setCompany($entreprise);
        }
        if ($type instanceof ProfessionLiberale){
            $userAdmin  
                ->setCurrentJob("Infirmier")
                ->setCompany($entreprise)
            ;
        }
        
        $manager-> persist($userAdmin);
        
        /******************** Poles ******************/ 
        //* creation tableau vide 
        $lesPoles = ["Com Recherche et developpement",'Evolution des savoirs', 'Evolution des metiers', 'Immobilier & Silver Experience', 'Universal design & inclusive design', 'Innovation' ];
        // $lePole   = $faker->randomElement($lesPoles);
        
        for($i=0 ; $i<=5 ; $i++) {
            
            $pole = new Pole();
            $pole->setNomPole($lesPoles[$i]);
                        
            $manager-> persist($pole);
            //* contenue de $pole dans le tableau pour attribuer à chaque type
            $poles[]=$pole;
        }
        
        /******************** Articles ******************/ 
        //* creation tableau vide 
        $articles =[];
        $poles = [
            'Innovation',
            'Evolution des metiers',
            'Evolution des savoirs',
            'Com Recherche et developpement',
            'Immobilier & Silver Experience',
            'Universal design & inclusive design' ,
        ];
        
        for($i=0 ; $i<=5; $i++){
            $article = new Articles();
            $poleId  = $faker->randomElement($lesPoles);
            
            $article   
                ->setTitreArticle($faker->word())
                ->setAccroche($faker->sentence())
                ->setPole($poles[$i])
                ->setIntro($faker->text())
                ->setContenu($faker->text())
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt)
                ->setRating(mt_rand(0,5))
                ->setAuthor($userAdmin)
            ;
                        
            $manager-> persist($article);
            
            //* contenue de $article dans le tableau pour attribuer à chaque type
            $articles[] = $article;
        }

        /******************** Retour Exp ******************/ 
        //* creation tableau vide 
        $retourExps =[];

        for($i=1 ; $i<=6 ; $i++){
            $retourExp = new RetourExp();
            $img = new Image();

            $retourExp  
                ->setTitrePublication($faker->word())
                ->setAccroche($faker->text())
                ->setIntro($faker->text())
                ->setContenu($faker->text())
                ->setImgRetourExp($img)
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt)
                ->setRating(mt_rand(0,5))
                ->setAuthor($userAdmin)
            ;
                        
            $manager-> persist($retourExp);

            //* contenue de $retourExp dans le tableau pour attribuer à chaque type
            $retourExps[]=$retourExp;
        }

        /******************** FaQuestions ******************/ 
        //* creation tableau vide 
        $foaQuestions =[];
        $rubriqueTab = ['Poles', 'Mon compte', 'Divers', 'Abonnements'];

        for($i=1 ; $i<=6 ; $i++){
            $faQuestions = new FaQuestions();
            $rubrique = $faker->randomElement($rubriqueTab);

            $faQuestions  
                ->setTitre($faker->word())
                ->setDescription($faker->text())
                ->setPole($pole)
                ->setAuthor($userAdmin)
                ->setRubrique($rubrique)
            ;
          
            $manager-> persist($faQuestions);

            //* contenue de $faQuestions dans le tableau pour attribuer à chaque type
            $foaQuestions[]=$faQuestions;
        }

        /******************** SecteurActivite ******************/ 
        //* creation tableau vide 
        $secteurActivites =[];

        for($i=1 ; $i<=6 ; $i++){
            $secteurActivite = new SecteurActivite();

            $secteurActivite  
                ->setTitre($faker->word())
                ->setDescription($faker->text())
                ->setPole($pole)
                ->setAuthor($userAdmin)
            ;
                        
            $manager-> persist($secteurActivite);

            //* contenue de $secteurActivite dans le tableau pour attribuer à chaque type
            $secteurActivites[]=$secteurActivite;
        }

        /******************** Images carousel ******************/ 
        //* creation tableau vide 
        $images =[];

        for($i=1 ; $i<=mt_rand(1,5) ; $i++){
            $image = new Images();

            $image
                ->setArticle($article)
                ->setRetourExp($retourExp)
            ;
                        
            $manager-> persist($image);

            //* contenue de $image dans le tableau pour attribuer à chaque type
            $images[]=$image;
        }

        /******************** Commentaires ******************/
        //* creation tableau vide 
        $commentaires = [];

        for($i = 1 ; $i <= 5 ; $i++){
            $commentaire = new Commentaire();

            $commentaire    
                ->setContenu($faker->text())
                ->setCreatedAt($createdAt)
                ->setRating(mt_rand(0,5))
                ->setArticle($article)
                ->setRetourExp($retourExp)
                ->setUserCommentaire($userAdmin)
            ;
            
            $manager-> persist($commentaire);

            //* contenue de $commentaire dans le tableau pour attribuer à chaque type
            $commentaires[]=$commentaire;
        } 

        /******************** Liker ******************/ 
        // creation tableau vide
        $likers = [];

        for($i=1 ; $i<=5 ; $i++) {
            $liker = new Liker();
            
            $liker  
                ->setUser($userAdmin)
                ->setArticle($article)
                ->setRetourExp($retourExp)
            ;                     
                        
            $manager-> persist($liker);

            //* contenue de $liker dans le tableau pour attribuer à chaque type
            $likers[]=$liker;
        }

        /******************** Newsletter ******************/ 
        //* creation tableau vide
        $newsletters =[];

        for($i=1 ; $i<=5 ; $i++){
            $newsletter = new Newsletter();

            $newsletter
                ->setTitleOne($faker->word())
                ->setDescOne($faker->word())
                ->setCreatedAt(new \DateTime())
            ;                     

            $manager-> persist($newsletter);

            //* contenue de $newsletter dans le tableau pour attribuer à chaque type
            $newsletters[]=$newsletter;
        }

        $manager->flush();

    }
}
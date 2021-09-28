<?php

namespace App\Controller;

use Exception;
use ArrayObject;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Salarie;
use App\Entity\Document;
use App\Entity\Etudiant;
use App\Entity\Retraite;
use App\Form\AdresseType;
use App\Form\SalarieType;
use App\Entity\Abonnement;
use App\Entity\SansEmploi;
use App\Form\ConnectedType;
use App\Entity\Entrepreneur;
use App\Form\InscriptionType;
use App\Entity\OffreAbonnement;
use App\Security\EmailVerifier;
use Doctrine\ORM\Mapping\Index;
use Doctrine\Common\Collections\Collection;
use App\Service\SecurityService;
use App\Entity\ProfessionLiberal;
use Symfony\Component\Mime\Email;
use App\Entity\ProfessionLiberale;
use App\Repository\UserRepository;
use App\Form\UpdateInscriptionType;
use App\Security\UserAuthenticator;
use Symfony\Component\Mime\Address;
use App\Repository\ArticlesRepository;
use App\Repository\DocumentRepository;
use App\Repository\RetourExpRepository;
use App\Repository\AbonnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ImageProfilRepository;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\MyAccountType\AccountSalarieType;
use Symfony\Component\HttpFoundation\Response;
use App\Form\MyAccountType\AccountEtudiantType;
use App\Form\MyAccountType\AccountRetraiteType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use App\Form\MyAccountType\AccountUnemployedType;
use App\Form\RegisterType\FormRegisterSalarieType;
use App\Form\MyAccountType\AccountEntrepreneurType;
use App\Form\RegisterType\FormRegisterEtudiantType;
use App\Form\RegisterType\FormRegisterRetraiteType;
use App\Form\RegisterType\FormRegisterUnemployedType;
use App\Form\RegisterType\FormRegisterEntrepreneurType;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\MyAccountType\AccountProfessionLiberaleType;
use App\Form\RegisterType\FormRegisterProfessionLiberaleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController {
    private $emailVerifier;
    private $authenticator;
    private $guardHandler;
    private $manager;

    public function __construct(EmailVerifier $emailVerifier, UserAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, EntityManagerInterface $manager) {
        $this->emailVerifier = $emailVerifier;
        $this->authenticator = $authenticator;
        $this->guardHandler  = $guardHandler;
        $this->manager       = $manager;
    }

    /**
     * Return a array with the user given(offset[0]) and the type:string(offset[1])
     * In case of error return a array with error message:string
     */
    public function TypeUser(User $user) :?Array {
        if ($user instanceof Entrepreneur) {
            return [$user, 'Entrepreneur'];
        } else if ($user instanceof Etudiant) {
            return [$user, 'Etudiant'];
        } else if ($user instanceof SansEmploi) {
            return [$user, 'SansEmploi'];
        } else if ($user instanceof Salarie) {
            return [$user, 'Salarie'];
        } else if ($user instanceof Retraite) {
            return [$user, 'Retraite'];
        } else if ($user instanceof ProfessionLiberale) {
            return [$user, 'ProfessionLiberale'];
        } else {
            return ['Error'];
        }
    }

    public function RenderForm(String $formUrl, String $actionUrl, String $formType, Object $user, Request $request, UserPasswordEncoderInterface $encoder) {
        $form = $this->createForm($formType, $user, [
            'action' => $actionUrl,
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //* set roles to user 
                $user->setRoles(
                    ["ROLE_USER"]
                );

                //* hash password
                $user->setPassword(
                    $encoder->encodePassword(
                        $user, $user->getPassword()
                    )
                );

                $this->manager->persist($user);
                $this->manager->flush();

                //* send a register confirmation token to the user's email
                $this->emailVerifier->sendEmailConfirmation('verifyEmail', $user,
                    (new TemplatedEmail())
                        ->from(new Address('gen@generation-boomerang.com', 'Génération Boomerang'))
                        ->to($user->getEmail())
                        ->subject('Bienvenue chez Génération Boomerang')
                        ->htmlTemplate('account/mail/register_confirmation_email.html.twig')
                    )
                ;

                //* redirect user to home page and instantly connect him with the created account
                return $this->guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->authenticator,
                    'actualite'
                );
            } catch (DriverException $e) {
                $this->addFlash('warning', "Error lors de la validation du formulaire");
                return $this->render('formulaire/RegisterForm.html.twig', [
                    'error' => true
                ]);
            }
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('warning', "Vérifiez que tous les champs soient renseignés correctement.");
            return $this->render('formulaire/RegisterForm.html.twig', [
                'error' => true
            ]);
        }

        return $this->render($formUrl, [
            'form' => $form->createView()
        ]);
    }

    /**
     * register forms for all user's type
     * @Route("/register/{type}", defaults={"type"=null}, name="registerForm")
     * @return Response
     */
    public function Register(?String $type, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder):Response {    
        if($type == 'SansEmploi') {

            //* Type of user create
            $user = new SansEmploi();
            //* Type of form (same as user type)
            $formType = FormRegisterUnemployedType::class;
            //* function render the form & check it when submit
            return $this->RenderForm('formulaire/formType/formRegisterSansEmploi.html.twig', '/register/SansEmploi', $formType, $user, $request, $encoder);

        } else if($type == 'Entrepreneur') {

            $user     = new Entrepreneur();
            $formType = FormRegisterEntrepreneurType::class;
            return $this->RenderForm('formulaire/formType/formRegisterEntrepreneur.html.twig', '/register/Entrepreneur', $formType, $user, $request, $encoder);

        } else if ($type == 'ProfessionLiberale') {

            $user     = new ProfessionLiberale();
            $formType = FormRegisterProfessionLiberaleType::class;
            return $this->RenderForm('formulaire/formType/formRegisterProfessionLiberale.html.twig', '/register/ProfessionLiberale', $formType, $user, $request, $encoder);

        } else if($type == 'Salarie') {
            
            $user     = new Salarie();
            $formType = FormRegisterSalarieType::class;
            return $this->RenderForm('formulaire/formType/formRegisterSalarie.html.twig', '/register/Salarie', $formType, $user, $request, $encoder);

        } else if ($type == 'Retraite') {

            $user     = new Retraite();
            $formType = FormRegisterRetraiteType::class;
            return $this->RenderForm('formulaire/formType/formRegisterRetraite.html.twig', '/register/Retraite', $formType, $user, $request, $encoder);

        } else if ($type == 'Etudiant') {

            $user     = new Etudiant();
            $formType = FormRegisterEtudiantType::class;
            return $this->RenderForm('formulaire/formType/formRegisterEtudiant.html.twig', '/register/Etudiant', $formType, $user, $request, $encoder);

        } else {
            return $this->render('formulaire/RegisterForm.html.twig', []);
        }    
    }

    /**
     * @Route("/verify/email", name="verifyEmail")
     */
    public function verifyUserEmail(Request $request):Response 
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('home');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('home');
    }

    /**
     * permet d'afficher la page entiere de l'user connecté
     * @Route("/account", name="account")
     * @IsGranted("ROLE_USER")
     */
    public function myAccount(ArticlesRepository $repo) {
        return $this->render('account/index.html.twig', [
            'user' => $this->getUser(),
            'articles' => $repo->findAll()
        ]);
    }

    /**
     * Page of subscription choice
     * @Route("/account/abonnements", name="abonnements_index") 
     */
    public function abonnementsIndex(AbonnementRepository $abonnementRepo) {
        $abonnement = $abonnementRepo->findAll();
        
        return $this->render('account/abonnement/abonnement_index.html.twig', [
            'abos' => $abonnement
        ]);
    }

    /**
     * subscription form receive a subscriptionOffer object and his details
     * @Route("/account/abonnement/{abo}", name="abonnement_form")
     */
    public function abonnement(OffreAbonnement $abo) {
        //TODO paramConverter

        return $this->render('account/abonnement/abonnement_form.html.twig', [
            'abo' => $abo
        ]);
    }

    /**
     * Page Mon Compte 
     * @Route("/mon-compte/", name="mon_compte")
     * @IsGranted("ROLE_USER")
     */
    public function monCompte(UserRepository $repoUsers, RetourExpRepository $repoRetourExp, ArticlesRepository $repoArticles, DocumentRepository $repoDocuments, Request $request, EntityManagerInterface $manager, ImageProfilRepository $imageRepo) {
        $user = $this->getUser();

        if ($user instanceof Entrepreneur) {
            $type = 'Entrepreneur';
            $form = $this->createForm(AccountEntrepreneurType::class, $user);
        } else if ($user instanceof Etudiant) {
            $type = 'Etudiant';
            $form = $this->createForm(AccountEtudiantType::class, $user);
        } else if ($user instanceof SansEmploi) {
            $type = 'SansEmploi';
            $form = $this->createForm(AccountUnemployedType::class, $user);
        } else if ($user instanceof Salarie) {
            $type = 'Salarie';
            $form = $this->createForm(AccountSalarieType::class, $user);
        } else if ($user instanceof Retraite) {
            $type = 'Retraite';
            $form = $this->createForm(AccountRetraiteType::class, $user);
        } else if ($user instanceof ProfessionLiberale) {
            $type = 'ProfessionLiberale';
            $form = $this->createForm(AccountProfessionLiberaleType::class, $user);
        } else {
            throw new \Exception("Error Processing Request", 1);
        }
        
        $form->handleRequest($request);
        
        $fichier = "";
        if ($form->isSubmitted() && $form->isValid()) {

            //* image de profil de l'user
            $fichier="";
            if ($user->getImgUserAvatar() != null ) 
                $fichier = $user->getImgUserAvatar()->getUserAvatar();
                 //* recuperation des images transmises            
            $imageRE = $form->get('imgUserAvatar')->getData();
            if($imageRE){
                //* on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $imageRE->guessExtension();

            //* on copie le fichier dans le dossier uploads/userAvatar
                $imageRE->move(
                    $this->getParameter('user_directory'),
                    $fichier
                );
            }

    
            $image = $imageRepo->FindOneBy(['imgUserAvatar' => $user->getId()]);

            if($image) {
                $image->setUserAvatar($fichier);
            } else { 
                $img = new Image();
           
                //* Set new profil picture
                $img->setUserAvatar($fichier);
                $user->setImgUserAvatar($img);

                $manager->persist($img);
            }
            
            if ($user instanceof SansEmploi){
                $docs = $form->get('documents')->getData(); 
                if($docs){
                    $doc = $docs[0];
                    $extension = $doc->guessExtension();
                    $fichier = md5(uniqid()) . '.' . $extension;

                    //* on copie le fichier dans le dossier uploads/userAvatar
                    $doc->move(
                        $this->getParameter('document_directory'),
                        $fichier);
                    $document = new Document();   
                    $document-> setFileName($fichier);
                    $document-> setUpdatedAt(new \DateTime('now'));     
                    $document-> setType($extension);  
                    $document-> setUser($user); 
                    $document-> setSansEmploieDocument($user); 
                    $manager->persist($document);    
                }
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du compte ont bien été modifiées "
            );
        }

        return $this->render('account/monCompte.html.twig', [
            'form'      => $form->createView(),
            'user'      => $user,
            'type'      => $type,
            'articles'  => $repoArticles->findAll(),
            'retourExp' => $repoRetourExp->findAll(),
            'documents'   =>$user->getDocuments(),
        ]);
    }

    /**
     * Bouton s'abonner a la newsletter
     * @Route("/mon-compte/subToNews", name="mon_compte_subToNews")
     * @IsGranted("ROLE_USER")
     */
    public function isSubToNews(EntityManagerInterface $manager ) {
        try {
            
            if($this->getUser()->getIsSubToNews() == False){
                //* S'abonner
                $user = $this->getUser()->setIsSubToNews(True);
                
                $manager->persist($user);
                $manager->flush();

                return $this->json(true);
            } else {
               //* Se desabonner 
               $user = $this->getUser()->setIsSubToNews(False);
                
                $manager->persist($user);
                $manager->flush();

                return $this->json(false);
            }
            

        } catch (DriverException $e) { 
            return $this->json($e->getMessage());
        }
    }


       /**
     * Permet d'afficher les infos de l'user depuis articles et experience
     * @Route("/show/detail/{id}", name ="user_show", methods={"GET"})
     * @return Response
     */
    public function showDetail(UserRepository $userRepo, ?int $id) {
        $user = $userRepo->FindOneBy(['id' => $id]);
                
        if ($user instanceof Entrepreneur) {
            $type = 'Entrepreneur';
        } else if ($user instanceof Etudiant) {
            $type = 'Etudiant';
        } else if ($user instanceof SansEmploi) {
            $type = 'SansEmploi';
        } else if ($user instanceof Salarie) {
            $type = 'Salarie';
        } else if ($user instanceof Retraite) {
            $type = 'Retraite';
        } else if ($user instanceof ProfessionLiberale) {
            $type = 'ProfessionLiberale';
        } else {
            echo "ko";
        };


        return $this->render('articles/userShow.html.twig', [ 
            'user' =>$user,
            'type' =>$type
   
        ]);
    }    
}
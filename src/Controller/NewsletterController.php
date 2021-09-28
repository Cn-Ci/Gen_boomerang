<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Entity\UserNewsletter;
use App\Security\EmailVerifier;
use App\Repository\PoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserNewsletterRepository;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
* @Route("/newsletter")
*/

class NewsletterController extends AbstractController {

    private $mailer;
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier,MailerInterface $mailer) {
        $this->mailer        = $mailer;
        $this->emailVerifier = $emailVerifier;
    }
    /**
     * @Route("/index", name="newsletter_index")
     */
    public function index(UserNewsletterRepository $userNewsletterRepo): Response {
        $user    = $this->getUser();  
        if($user){        
            $usersNewsletter = $userNewsletterRepo->findOneBy(['email' => $user->getEmail()]);   
            if($usersNewsletter == null){
                $usersNewsletter = new UserNewsletter();                        
            }   
            return $this->render('newsletter/index.html.twig', [
                'usersNewsletter'=>$usersNewsletter,
                'poles'=>$usersNewsletter->getPoles(),
            ]);

        }else
        return $this->render('error/not_connected.html.twig', [
            'controller_name' => 'NewsletterController',
        ]); 
    }

            /**
     * @Route("/newsletter/subscr/{nrPole}", name="newsletter_subscribe",methods={"GET","POST"})
     */
    public function subscr(?int $nrPole,Request $request, EntityManagerInterface $manager, UserNewsletterRepository $userNewsletterRepo, PoleRepository $poleRepo): Response {
        $subject ='';

        $user    = $this->getUser();  
        $userNewsletter = $userNewsletterRepo->findOneBy(['email' => $user->getEmail()]);
        $poleExist = $userNewsletterRepo->findByPoleId($nrPole,$user->getEmail());
        $pole = $poleRepo->find($nrPole);
        if(!$userNewsletter){
            $userNewsletter = new UserNewsletter(); 
            $userNewsletter->setEmail($user->getEmail());               
            $userNewsletter->addPole($pole);  
            $userNewsletter->setIsRgpd(true);            
            $manager->persist($userNewsletter);
            $manager->flush();
              
        }else{
            if($poleExist){
                $userNewsletter->removePole($pole);  
                $subject = 'desinscription' ; 
       
            }else{
                $userNewsletter->addPole($pole);
                $subject = 'inscription';
                
            }
            $manager->persist($userNewsletter);
            $manager->flush();
        }
        $name = $user->getFullName();
        if($poleExist){

                $user->setIsSubToNews(false);  
        }
        else
                $user->setIsSubToNews(true);  
        $manager->persist($user);
        $manager->flush();      
        $this->mailForNewsletter($userNewsletter->getEmail(), $subject, 
        'newsletter/inscription_newsletter.html.twig', $name, $nrPole); 
        if(!$poleExist){
        return $this->render('newsletter/confirm_newsletter.html.twig', [
            'userNewsletter'=>$userNewsletter,
        ]);}else{
        return $this->render('newsletter/discard_newsletter.html.twig', [
           'userNewsletter'=>$userNewsletter,
        ]);}
    }    

    public function new(Int $nbr,Request $request, EntityManagerInterface $manager, MailerService $mailer, UserRepository $userRepo):Response {
        $newsletter = new Newsletter();
        
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $users = $userRepo->findBy(["isSubToNews" => True]);

            $mailer->sendNewsletter(
                $users, 
                "newsletter/model_newsletter$nbr.html.twig", 
                Array(
                    $form->getData('titleOne'),
                    $form->getData('titleTwo'),
                    $form->getData('descOne'),
                    $form->getData('descTwo'),
                )
            );

            $manager->persist($newsletter);
            $manager->flush();


            $this->addFlash(
                'success',
                "L'inscription à la newsletter a bien été enregistrée !"
            );
        }

        switch ($nbr) {
            case '1':
                return $this->render('newsletter/new1.html.twig', [
                    // 'pole' => $pole,
                    'nbr' => $nbr,
                    'form' => $form->createView()
                ]);
                break;
            case '2':
                return $this->render('newsletter/new2.html.twig', [
                    'form' => $form->createView()
                ]);
                break;
            case '3':
                return $this->render('newsletter/new3.html.twig', [
                    'form' => $form->createView()
                ]);
                break;
            
            default:
                return $this->render('newsletter/new1.html.twig', [
                    'form' => $form->createView(),
                ]);
                break;
        }
    }

    /**
     * @Route("/newsletter/type", name="typeNewsletter")
     */
    public function type(): Response
    {
        return $this->render('newsletter/type_newsletter.html.twig', [
            'controller_name' => 'NewsletterController',
        ]);
    }


    public function mailForNewsletter(String $receiver, String $subject, String $template, String $name, int $nrPole){
        $poles = array( array('Com Recherche et developpement','communication2.png'),
                        array('Evolution des savoirs','savoirs2.png'),
                        array('Evolution des metiers','metiers2.png'),
                        array('Immobilier & Silver Experience','immobilier2.png'),
                        array('Universal design & inclusive design','design2.png'),
                        array('Innovation','innovation2.png')
                        );
        try {
                $email = (new TemplatedEmail())
                ->from('gen@generation-boomerang.com')
                ->to($receiver)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context([
                    'name'=> $name,
                    'subject' => $subject,
                    'pole' => $poles[$nrPole-1][0], 
                    'pole_img' => $poles[$nrPole-1][1]                           
                ])
            ;
    
            $this->mailer->send($email);
        } catch (DriverException $e) {
            $e->getMessage();
        }
        return $email;
    }
}

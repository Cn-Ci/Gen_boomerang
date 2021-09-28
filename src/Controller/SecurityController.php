<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController {

    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer        = $mailer;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils):Response {
        //* get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        //* last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() 
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
    * @Route("/app_forgotten_password", name="app_forgotten_password")
    */
    public function oubliPass(Request $request, UserRepository $user, TokenGeneratorInterface $tokenGenerator):Response 
    {
        
        //* On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);

        //* On traite le formulaire
        $form->handleRequest($request);

        //* Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) 
        {
            //* On récupère les données
            $donnees = $form->getData();

            //* On cherche un utilisateur ayant cet e-mail
            $user = $user->findOneBy(array('email' => $donnees['email']));

            //* Si l'utilisateur n'existe pas
            if ($user === null) 
            {
                //* On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
    
                //* On retourne sur la page de connexion
                return $this->redirectToRoute('app_login');
            }

            //* On génère un token
            $token = $tokenGenerator->generateToken();

            //* On essaie d'écrire le token en base de données
            try 
            {
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } 
            catch (\Exception $e) 
            {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            //* On génère l'URL de réinitialisation de mot de passe
            $url = $this->generateUrl('app_reset_password', array('token' => $token,'email' => $donnees['email']), UrlGeneratorInterface::ABSOLUTE_URL);
            //* On génère l'e-mail
            $email = (new TemplatedEmail())
            ->from(Address::create('Génération Boomerang<gen@generation-boomerang.com>'))
            ->to($user->getEmail())
            ->subject('Mot de passe oublié')
            ->html('Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Génération-boomerang.com, Veuillez cliquer sur le lien suivant : ' . $url);
            

            //* On envoie l'e-mail
            //$mailer->send($message);

            $this->mailer->send($email);
            //* On crée le message flash de confirmation
            $this->addFlash('success', 'E-mail de réinitialisation du mot de passe envoyé !');

            //* On redirige vers la page de login
            return $this->redirectToRoute('app_login');
        }

        //* On envoie le formulaire à la vue
        return $this->render('security/forgotten_password.html.twig',['emailForm' => $form->createView()]);
    }

    /**
    * @Route("/app_reset_password/{token}/{email}", name="app_reset_password")
    */
    public function resetPassword(string $token, string $email, Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $user) 
    {
        //* On cherche un utilisateur avec le token donné
        /*$user = $this->getUser();

        //* Si l'utilisateur n'existe pas
        if ($user === null) {
            //* On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
        }*/
        $user = $user->findOneBy(array('reset_token' => $token));
        
        //* Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) 
        {
            if ($user === null)
            {
                $this->addFlash('danger', 'Lien obsolete');
                return $this->redirectToRoute('app_login');
            }
            else
            {
                $user->setResetToken(null);

                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
    
                //* On stocke
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
    
                //* On crée le message flash
                $this->addFlash('success', 'Mot de passe mis à jour');
        
                //* On redirige vers la page de connexion
                return $this->redirectToRoute('app_login');
            }
        } 
        else 
        {   
            //* Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('security/reset_password.html.twig', [
                'email' => $email, 'token' => $token
            ]);
        }
    }

    /**
    * @Route("/reset_forgot_password/", name="reset_forgot_password")
    */
    
    public function UpdatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        //* On cherche un utilisateur avec le token donné
        $user = $this->getUser();

        //* Si l'utilisateur n'existe pas
        if ($user === null) 
        {
            //* On affiche une erreur
            $this->addFlash('danger', 'l\'utilisateur non connecté');
            return $this->redirectToRoute('app_login');
        }
     
        //* Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) 
        {
            //* On chiffre le mot de passe
            $oldPass =  $request->request->get('oldPassword');

            if(password_verify($oldPass, $user->getPassword())) 
            {
                //* On chiffre le mot de passe
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

                //* On stocke
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                //* On crée le message flash
                $this->addFlash('success', 'Mot de passe mis à jour');

                //* On redirige vers la page de connexion
                return $this->redirectToRoute('app_login');
            }
            else
            {
                $this->addFlash('danger', 'Votre ancien mot de passe est faux');
                return $this->redirectToRoute('mon_compte');
            }
        } 
        else 
        {
            //* Si on n'a pas reçu les données, on affiche le formulaire
            $this->addFlash('danger', 'Les données ont fuck my wife');
            return $this->redirectToRoute('mon_compte');
        }
    }
}
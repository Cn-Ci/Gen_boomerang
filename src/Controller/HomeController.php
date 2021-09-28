<?php

namespace App\Controller;

use App\Service\StatsService;
use App\Repository\PoleRepository;
use App\Repository\UserRepository;
use App\Repository\ArticlesRepository;

use App\Form\ResetPassType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Repository\RetourExpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer        = $mailer;
    }

    /**
     * @Route("/", name="home")
     */
    public function newIndex() {
        return $this->render('home/newIndex.html.twig');
    }

    /**
     * @Route("/accessibilite", name="accessibilite")
     */
    public function accessibilite() {
        return $this->render('home/accessibilite.html.twig');
    }

    /**
     * @Route("/partenaire", name="partenaire")
     */
    public function partenaire() {
        return $this->render('home/partenaire.html.twig');
    }

    /**
     * @Route("/a-propos", name="a-propos")
     */
    public function aPropos() {

        return $this->render('home/aPropos.html.twig');
    }

    /**
     * @Route("/ChangerDeVie", name="changerDeVie")
     */
    public function presentation() {
        return $this->render('home/changerDeVie.html.twig');
    }

    /**
     * @Route("/actualite", name="actualite")
     */
    public function actualite(EntityManagerInterface $manager, ArticlesRepository $articleRepo, PoleRepository $polesRepo, RetourExpRepository $retourExpRepo) {
        //* articles
        $article = $articleRepo->findAll();

        //* poles
        $poles = $polesRepo->findAll();

        //* liste des pole dans un tableau
        $lastArticlesByPole = [];

        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $lastArticlesByPole[$pole->getNomPole()]= $articleRepo->findLastArticles($pole);
        }     

        return $this->render('home/actualite.html.twig', [
            //* articles
            'bestArticles' => $articleRepo->findBestArticles(3),
            'lastArticles' => $lastArticlesByPole,
            'art' => $article,

            //* retourExp
            "bestRetourExp" => $retourExpRepo->findBestRetourExp(3),
            'lastRetourExp' => $retourExpRepo->findLastRetourExp()
        ]);
    }

    
    /**
     * @Route("/aideContact", name="aideContact")
     */
    public function aideContact(){
        return $this->render('home/aideContact.html.twig');
    }

        /**
     * @Route("/aide", name="aide")
     */
    public function aide(){
        return $this->render('home/aide.html.twig');
    }

    /**
    * @Route("/send_faq_mail/", name="app_send_faq_mail")
    */
    public function mailFaq(Request $request) 
    {
        
        $nom = $request->request->get('name');
        $email = $request->request->get('email');
        $text = $request->request->get('message');

        //* On génère l'e-mail
        $email = (new TemplatedEmail())
        ->from($email)
        ->to("gen@generation-boomerang.com")
        ->subject('Renseignement FAQ')
        ->html('Message de '.$nom.' :<br><br>'.$text.'<br><br>Génération Boomerang | FAQ');
    
        $this->mailer->send($email);
    
        $this->addFlash('success', 'Votre message a été envoyé avec succés, nous vous répondrons dans les plus bref délais');

        
        return $this->redirectToRoute('poles_faq');
    }
}
<?php

namespace App\Controller;

use App\Entity\Pole;
use App\Repository\PoleRepository;
use App\Repository\ArticlesRepository;
use App\Repository\FaQuestionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/poles")
*/
class PoleController extends AbstractController {
    /**
     * @Route("/presentation", name="poles_index")
     */
    public function index() {
        return $this->render('poles/index.html.twig');
    }
    
    /**
     * @Route("/faq", name="poles_faq")
     */
    public function faQuestions(FaQuestionsRepository $faqRepo) {
        $questions = $faqRepo->FindAll();
        return $this->render('poles/faq.html.twig', [
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/secteurActivite", name="poles_secteurActivite")
     */
    public function secteurActivite() {
        return $this->render('poles/secteurActivite.html.twig');
    }

    /**
     * @Route("/evolutionsMetier", name="evolutionsMetier")
     */
    public function evolutionsMetier() {
        return $this->render('poles/evoMetierPole/evolutionsMetier.html.twig');
    }

    /**
     * @Route("/evolutionsMetier/contact", name="contactEvolutionsMetier")
     */
    public function contactEvolutionsMetier(ArticlesRepository $articleRepo, PoleRepository $polesRepo) {
        $article = $articleRepo->findAll();
        $poles = $polesRepo->findAll();

        //* liste des pole dans un tableau
        $bestArticlesByPole = [];

        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $bestArticlesByPole[$pole->getNomPole()]= $articleRepo->findBestArticlesByPole($pole, 3);
        }

        return $this->render('poles/contact/contactEvolutionsMetier.html.twig', [
            'article' => $article,
            'bestArticles' => $bestArticlesByPole,
        ]);
    }

    /**
     * @Route("/innovation", name="innovation")
     */
    public function innovation() {
        return $this->render('poles/pole/Innovation.html.twig');
    }

    /**
     * @Route("/innovation/contact", name="contactInnovation")
     */
    public function contactInnovation(ArticlesRepository $articleRepo, PoleRepository $polesRepo) {
        $article = $articleRepo->findAll();
        $poles = $polesRepo->findAll();
        //* liste des pole dans un tableau
        $bestArticlesByPole = [];
        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $bestArticlesByPole[$pole->getNomPole()]= $articleRepo->findBestArticlesByPole($pole, 3);
        }
        return $this->render('poles/contact/contactInnovation.html.twig', [
            'article' => $article,
            'bestArticles' => $bestArticlesByPole,
        ]);
    }

    /**
     * @Route("/evolutionSavoirs", name="evolutionSavoirs")
     */
    public function evolutionSavoirs() {
        return $this->render('poles/pole/evolutionSavoirs.html.twig');
    }

    /**
     * @Route("/evolutionSavoirs/contact", name="contactEvolutionSavoirs")
     */
    public function contactEvolutionSavoirs(ArticlesRepository $articleRepo, PoleRepository $polesRepo) {
        $article = $articleRepo->findAll();
        $poles = $polesRepo->findAll();
        //* liste des pole dans un tableau
        $bestArticlesByPole = [];
        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $bestArticlesByPole[$pole->getNomPole()]= $articleRepo->findBestArticlesByPole($pole, 3);
        }
        return $this->render('poles/contact/contactEvolutionSavoirs.html.twig', [
            'article' => $article,
            'bestArticles' => $bestArticlesByPole,
        ]);
    }

    /**
     * @Route("/commRechercheDev", name="commRechercheDev")
     */
    public function commRechercheDev() {
        return $this->render('poles/pole/commRechercheDev.html.twig');
    }

    /**
     * @Route("/commRechercheDev/contact", name="contactCommRechercheDev")
     */
    public function contactCommRechercheDev(ArticlesRepository $articleRepo, PoleRepository $polesRepo) {
        $article = $articleRepo->findAll();
        $poles   = $polesRepo->findAll();

        //* liste des pole dans un tableau
        $bestArticlesByPole = [];

        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $bestArticlesByPole[$pole->getNomPole()]= $articleRepo->findBestArticlesByPole($pole, 3);
        }

        return $this->render('poles/contact/contactCommRechercheDev.html.twig', [
            'article' => $article,
            'bestArticles' => $bestArticlesByPole,
        ]);
    }

    /**
     * @Route("/design", name="design")
     */
    public function design() {
        return $this->render('poles/pole/design.html.twig');
    }

    /**
     * @Route("/design/contact", name="contactDesign")
     */
    public function contactDesign(ArticlesRepository $articleRepo, PoleRepository $polesRepo) {
        $article = $articleRepo->findAll();
        $poles   = $polesRepo->findAll();

        //* liste des pole dans un tableau
        $bestArticlesByPole = [];

        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $bestArticlesByPole[$pole->getNomPole()]= $articleRepo->findBestArticlesByPole($pole, 3);
        }

        return $this->render('poles/contact/contactDesign.html.twig', [
            'article' => $article,
            'bestArticles' => $bestArticlesByPole,
        ]);
    }

    /**
     * @Route("/immobilier", name="immobilier")
     */
    public function immobilier() {
        return $this->render('poles/pole/immobilier.html.twig');
    }

    /**
     * @Route("/immobilier/contact", name="contactImmobilier")
     */
    public function contactImmobilier(ArticlesRepository $articleRepo, PoleRepository $polesRepo) {
        $article = $articleRepo->findAll();
        $poles   = $polesRepo->findAll();

        //* liste des pole dans un tableau
        $bestArticlesByPole = [];
        //* Pour chaque pole on recupere le nom et le compare au pole des derniers articles
        foreach($poles as $pole) {
            $bestArticlesByPole[$pole->getNomPole()]= $articleRepo->findBestArticlesByPole($pole, 3);
        }

        return $this->render('poles/contact/contactImmobilier.html.twig', [
            'article' => $article,
            'bestArticles' => $bestArticlesByPole,
        ]);
    }
}
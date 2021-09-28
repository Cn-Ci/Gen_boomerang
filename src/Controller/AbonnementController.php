<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Repository\AbonnementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class AbonnementController extends AbstractController {
    /**
     * @Route("/abonnementNew/{id}", name="abonnement_new", defaults={"id" = null})
     */
    public function index(AbonnementRepository $repo, ?int $id, Request $request): Response{
        // $id2 = $request->attributes->get('id');
        $abos = $repo->findAll();
        $aboById = $repo->findOneBy(['id' => $id]);
        
        return $this->render('account/abonnement/abonnement_form.html.twig', [
            'abos' => $abos,
            // 'id' => $id,
            'abonnement' => $aboById
        ]);
    }

    /**
     * AFFICHE LA RUBRIQUE DE DROITE SUR LA PAGE ABONNEMENT
     * @Route("/renderAbo/{id}", name="renderAbo")
     */
    public function afficherDetailAbo(AbonnementRepository $repo, Abonnement $abo) :Response {
        $abonnement = $repo->findOneBy(['id' => $abo->getId()]);

        return $this->render('account/abonnement/detailAbonnement.html.twig', [
            'abonnement' => $abonnement
        ]);
    }
}
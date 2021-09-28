<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Entity\Etudiant;
use App\Entity\Retraite;
use App\Entity\SansEmploi;
use App\Entity\Entrepreneur;
use App\Entity\ProfessionLiberale;
use App\Repository\UserRepository;
use App\Repository\AdresseRepository;
use App\Repository\ArticlesRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\CommentaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReseauController extends AbstractController {
    /**
     * @Route("/reseau/detail/{id}", name="detailMembre")
     */
    public function detailMembre(UserRepository $userRepo, EntrepriseRepository $steRepo, AdresseRepository $adresseRepo, ?int $id): Response{
        $user = $userRepo->FindOneBy(['id' => $id]);
    
       $type = $user->getType();

        return $this->render('reseau/detailMembre.html.twig', [
            'user' => $user,
            'type' => $type
        ]);
    }

    /**
     * @Route("/reseau/search/", name="searchMembre")
     */
    public function searchMembre(UserRepository $userRepo, PaginatorInterface $paginator, Request $request): Response {
        $userPaginator = $paginator->paginate($userRepo->findAll(), $request->query->getInt('page', 1),9);
        $test ='';

        return $this->render('reseau/searchMembre.html.twig', [
            'users' => $userPaginator,
            'test' => $test
        ]);
    }

    /**
     * permet de filtrer (recherche)
     * @Route("reseau/search/orderByType/{filter}", name="usersOrderByType")
     */
    public function orderUserByType(UserRepository $userRepo, String $filter, Request $request, PaginatorInterface $paginator) {
        $usersSearched = [];

        foreach($userRepo->findAll() as $user){  
            //* If the type of user match with the filter add the user in the array
            if ($filter == $user->getTypeWithoutSpecialChart()) {
                array_push($usersSearched, $user);
            }
        }
        
        //* In case of there is no user with the type selected we return simply findAll()
        if (count($usersSearched) > 0) {
            $userPaginator = $paginator->paginate($usersSearched, $request->query->getInt('page', 1),9);
        } else {
            $userPaginator = $paginator->paginate($userRepo->findAll(), $request->query->getInt('page', 1),9);
        }

        return $this->render('reseau/searchMembre.html.twig', [
            'users' => $userPaginator,
        ]);
    }

    /**
     * barre de recherche
     * @Route("reseau/search/searchBar/{keyword}", name="searchToolsMembre")
     */
    public function searchTools(UserRepository $userRepo, Request $request, String $keyword, PaginatorInterface $paginator){
        $membresSearched = [];
        $users           = $userRepo->findAll();
        
        foreach ($users as $user) {
            $Nom    = strtolower($user->getLastName());
            $Prenom = strtolower($user->getFirstName());

            if ($user instanceof Entrepreneur) {
                $metier = strtolower($user->getCompany());
            } else if ($user instanceof Etudiant) {
                $metier = strtolower($user->getDomainStudies());
            } else if ($user instanceof SansEmploi) {
                $metier = strtolower($user->getSearchedJob());
            } else if ($user instanceof Salarie) {
                $metier = strtolower($user->getCurrentJob());
            } else if ($user instanceof Retraite) {
                $metier = strtolower($user->getPrecedentJobs());
            } else if ($user instanceof ProfessionLiberale) {
                $metier = strtolower($user->getCompany());
            } else {
                echo "ko";
            }

            //* Check if the keyword is contain in Title or in Accroche or in author firstname & lastname
            if (preg_match('/' . $Nom . '/', $keyword)    || str_contains($Nom, $keyword) ||
                preg_match('/' . $Prenom . '/', $keyword) || str_contains($Prenom, $keyword) ||
                preg_match('/' . $metier . '/', $keyword) || str_contains($metier, $keyword)) {

                array_push($membresSearched, $user);
            }
        }

        if (count($membresSearched) > 0) {
            $userPaginator = $paginator->paginate($membresSearched, $request->query->getInt('page', 1),9);
        } else {
            $userPaginator = $paginator->paginate($users, $request->query->getInt('page', 1),9);
        }

        return $this->render('reseau/searchMembre.html.twig', [
            'users' => $userPaginator,
        ]);
    }
}
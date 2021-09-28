<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Images;
use App\Entity\Salarie;
use App\Entity\Etudiant;
use App\Entity\Retraite;
use App\Entity\RetourExp;
use App\Entity\SansEmploi;
use App\Entity\Commentaire;
use App\Form\RetourExpType;
use App\Entity\Entrepreneur;
use App\Form\CommentairesType;
use App\Service\SecurityService;
use App\Entity\ProfessionLiberale;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use App\Repository\RetourExpRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ImageProfilRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RetourExpController extends AbstractController {
    /**
     * Voir toutes les publications
     * @Route("/experience/publications", name="experience")
     */
    public function publications(RetourExpRepository $publicationRepo, Request $request, PaginatorInterface $paginator):Response {
        $publication = $publicationRepo->findAll();
        $publicationPaginator = $paginator->paginate($publication, $request->query->getInt('page', 1),6);

        return $this->render('retour_exp/index.html.twig', [
           'publication' => $publicationPaginator,
        ]);
    }

    /**
     * Nouvelle publication
     * @Route("experience/new", name="experience_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_FONDATEUR') or is_granted('ROLE_ABONNE')")
     */
    public function new(Request $request, EntityManagerInterface $manager):Response {
        $publication = new RetourExp();

        $form = $this->createForm(RetourExpType::class, $publication);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            //* image de profil de l'article
            //* recuperation des images transmises
            $imageRE = $form->get('imgRetourExp')->getData();

            if ($imageRE) {
                //* on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $imageRE->guessExtension();
                //* on copie le fichier dans le dossier uploads/retourExp
                $imageRE->move(
                    $this->getParameter('retourExp_directory'),
                    $fichier
                );
            } else {
                $fichier = null;
            }

            $img= new Image();

            //* on met le nom du fichier dans ImageRexp
            $img->setImageRExp($fichier);

            //* on ajoute l'image au retour Exp correspondant
            $img->setImgRetourExp($publication);

            $publication->setImgRetourExp($img);
            
            $manager->persist($publication);
            $manager->flush();

            // Images de l'articles     
            $images = $form->get('images')->getData();
            foreach($images as $image) {
                // on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //on copie le fichier dans le dossier uploads/carousel
                $image->move(
                    $this->getParameter('image_directory'),
                    $fichier
                );

                $img= new Images();
                $img->setImages($fichier);
                
                $publication->addImage($img);
            }

            $publication->setAuthor($this->getUser());
            
            $manager->persist($publication);
            $manager->flush();

            $this->addFlash(
                'success',
                "La publication <strong>{$publication->getTitrepublication()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('experience', [
                'slug' => $publication->getSlug()
            ]);
        }

        return $this->render('retour_exp/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifier la publication
     * @Route("/experience/{slug}/edit", name="experience_edit")
     * @Security("is_granted('ROLE_USER') and user === retourExp.getAuthor() or is_granted('ROLE_ADMIN')", message="Cette publication ne vous appartient pas, vous ne pouvez pas la modifier !")
     * @return Response
     */
    public function edit(RetourExp $retourExp, Request $request, EntityManagerInterface $manager, ImageProfilRepository $imageRepo) {
        $form = $this->createForm(RetourExpType::class, $retourExp);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //* image de profil de l'article
            //* recuperation des images transmises

            $imageRE = $form->get('imgRetourExp')->getData();
            
            if($imageRE == null) {
                if ($retourExp->getImgRetourExp() != null) {
                    $imageRE = $retourExp->getImgRetourExp()->getImageRExp();  
                    $fichier = $imageRepo->findOneBy(['imageRExp' => $imageRE])->getImageRExp();
                } else {
                    $fichier = null;
                    $retourExp->setImgRetourExp(null);
                }
            } else {
                //* on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $imageRE->guessExtension();
                //* on copie le fichier dans le dossier uploads/retourExp
                $imageRE->move(
                    $this->getParameter('retourExp_directory'),
                    $fichier
                );
            }
            
            $image = $imageRepo->FindOneBy(['imgRetourExp' => $retourExp->getId()]);

            if($image) {
                $image->setImageRExp($fichier);
            } else { 
                $img = new Image();
           
                //* on met le nom du fichier dans ImageRexp
                $img->setImageRExp($fichier);
                $manager->persist($img);
                $retourExp->setImgRetourExp($img);
            }

            //* Images de l'articles     
            $images = $form->get('images')->getData();
            foreach($images as $image) {
                //* on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //* on copie le fichier dans le dossier uploads/carousel
                $image->move(
                    $this->getParameter('image_directory'),
                    $fichier
                );

                $img= new Images();

                $img->setImages($fichier);
                $retourExp->addImage($img);
            }

            $manager->persist($retourExp);
            $manager->flush();

            $this->addFlash(
                'success',
                "La publication <strong>{$retourExp->getTitrePublication()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('experience_show', [
                'slug' => $retourExp->getSlug()
            ]);
        }

        return $this->render('retour_exp/edit.html.twig', [
            'form' => $form->createView(),
            'retourExp' => $retourExp
        ]);
    }

    /**
     * Supprimer les images
     * @Route("/experience/delete/image/{id}", name="experience_delete_image", methods={"GET","DELETE"})
     */
    public function deleteImage(Images $image, Request $request) {
        $data = json_decode($request->getContent(), true);

        //* On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])){
            //* On récupère le nom de l'image
            $nom = $image->getImages();
            //* On supprime le fichier
            unlink($this->getParameter('image_directory').'/'.$nom);

            //* On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
    
    /**
     * Supprime une publication
     * @Route("/experience/{slug}/delete", name="experience_delete")
     * @Security("is_granted('ROLE_USER')")
     * @param RetourExp $publication
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(RetourExp $retourExp, EntityManagerInterface $manager){
        $manager->remove($retourExp);
        $manager->flush();

        $this->addFlash(
            'success',
            "La publication <strong>{$retourExp->getTitrePublication()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute('experience');
    }

    /**
     * Voir une publication
     * @Route("experience/{slug}", name="experience_show")
     */
    public function publication(RetourExpRepository $repoRetourExp, $slug, Request $request, EntityManagerInterface $manager) {
        $publication = $repoRetourExp->findOneBy(['slug' => $slug]);
        //* Increment number of views 
        $publication->setViews($publication->getViews() + 1);
        $manager->flush();
        
        $user = $publication->getAuthor();
        $type = $user->getType();

        //* Formulaire ajout de commentaire
        $comment = new Commentaire();

        $form = $this->createForm(CommentairesType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setretourExp($publication)
                ->setCreatedAt(new \DateTime ('now'))
                ->setUserCommentaire($this->getUser())
            ;

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire a bien été pris en compte !"
            );
        }
        
        return $this->render('retour_exp/show.html.twig', [
            'form'        => $form->createView(),
            'publication' => $publication,
            'type'        => $type
        ]);
    }

    /**
     * permet de filtrer (recherche)
     * @Route("experience/orderBy/{filter}", name="retourExpOrderBy")
     */
    public function orderRetourExpBy(RetourExpRepository $repoRetourExp, Request $request, PaginatorInterface $paginator, String $filter) {
        if ($filter == 'oldest') {
            $publication = $repoRetourExp->findBy([], ['createdAt' => 'ASC']);
        } else if ($filter == 'latest') {
            $publication = $repoRetourExp->findBy([], ['createdAt' => 'DESC']);
        } else if ($filter == 'none') {
            $publication = $repoRetourExp->findAll();
        }

        $publicationPaginator = $paginator->paginate($publication, $request->query->getInt('page', 1),6);

        return $this->render('retour_exp/index.html.twig', [
            'publication' => $publicationPaginator
        ]);
    }

    /**
     * @Route("experience/searchBar/{keyword}", name="searchToolsExp")
     */
    public function searchTools(RetourExpRepository $repoRetourExp, Request $request, String $keyword, PaginatorInterface $paginator) {
        $publicationSearched = [];
        $publications        = $repoRetourExp->findAll();
        
        foreach ($publications as $publication) {
            $accroche     = strtolower($publication->getAccroche());
            $title        = strtolower($publication->getTitrePublication());
            $authorNom    = strtolower($publication->getAuthor()->getLastName());
            $authorPrenom = strtolower($publication->getAuthor()->getFirstName());

            //* Check if the keyword is contain in Title or in Accroche or in author firstname & lastname
            if (preg_match('/' . $title . '/', $keyword)        || str_contains($title, $keyword)     ||
                preg_match('/' . $accroche . '/', $keyword)     || str_contains($accroche, $keyword)  || 
                preg_match('/' . $authorNom . '/', $keyword)    || str_contains($authorNom, $keyword) ||
                preg_match('/' . $authorPrenom . '/', $keyword) || str_contains($authorPrenom, $keyword)) {

                array_push($publicationSearched, $publication);
            }
        }

        if (count($publicationSearched) > 0) {
            $publicationsPaginator = $paginator->paginate($publicationSearched, $request->query->getInt('page', 1),6);
        } else {
            $publicationsPaginator = $paginator->paginate($publications, $request->query->getInt('page', 1),6);
        }

        return $this->render('retour_exp/index.html.twig', [
            'publication' => $publicationsPaginator
        ]);
    }

    /**
     * Supprime un commentaire
     * @Route("experience/deleteComm/{id}", name="comm_Rexp_delete")
     */
    public function deleteComm(Commentaire $comm, Request $request, Commentaire $id):Response {
        try {
            if ($this->isCsrfTokenValid('delete-comm' . $comm->getId(), $request->request->get('_token'))) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($comm);
                $manager->flush();
            } else {
                $this->addFlash(
                    'error',
                    "Invalid Token"
                );

                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
        } catch (DriverException $e) {
            $this->addFlash(
                'Error',
                $e->getMessage()
            );

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $this->addFlash(
            'success',
            "Votre commentaire à bien été supprimer"
        );

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * modifier un commentaire
     * @Route("experience/modifComm/{id}", name="comm_Rexp_modify")
     */
    public function modifyComm(Commentaire $comm, Request $request, Int $id):Response {
        try {
            $comm->setContenu($request->request->get('request'));
            
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
        } catch (DriverException $e) {
            return $this->json([
                'code'    => 500, 
                'message' => 'Internal server error.'
            ], 500);
        }

        return $this->json([
            'code'    => 200, 
            'message' => 'Votre commentaire a été modifié avec succès.'
        ], 200);
    }

    /**
     * like a publication
     * @Route("experience/like/{id}", name="likeRetourExp")
     */
    public function likeRetourExp(Request $request, RetourExp $publication, SecurityService $security):Response {
        try {
            $user = $security->getUser();
            
            $user->addRetourExpLiked($publication);
            $publication->addUsersLiker($user);
            $publication->setLikes($publication->getLikes() + 1);

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
        } catch (DriverException $e) {
            return $this->json([
                'code'    => 500, 
                'message' => 'Internal server error.'
            ], 500);
        }

        return $this->json([
            'code'    => 200, 
            'message' => 'Votre like a bien été ajouté.'
        ], 200);
    }

    /**
     * unlike a publication
     * @Route("experience/unlike/{id}", name="unlikeRetourExp")
     */
    public function unlikeRetourExp(Request $request, RetourExp $publication, SecurityService $security):Response {
        try {
            $user = $security->getUser();
            
            $user->removeRetourExpLiked($publication);
            $publication->removeUsersLiker($user);
            $publication->setLikes($publication->getLikes() - 1);

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
        } catch (DriverException $e) {
            return $this->json([
                'code'    => 500, 
                'message' => 'Internal server error.'
            ], 500);
        }

        return $this->json([
            'code'    => 200, 
            'message' => 'Votre like a bien été retiré.'
        ], 200);
    }
}
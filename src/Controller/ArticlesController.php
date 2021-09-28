<?php

namespace App\Controller;

use App\Entity\Pole;
use App\Entity\Image;
use App\Entity\Liker;
use App\Entity\Images;
use App\Entity\Salarie;
use App\Entity\Articles;
use App\Entity\Etudiant;
use App\Entity\Retraite;
use App\Entity\SansEmploi;
use App\Form\ArticlesType;
use Cocur\Slugify\Slugify;
use App\Entity\Commentaire;
use App\Entity\Commentaires;
use App\Entity\Entrepreneur;
use App\Form\CommentairesType;
use App\Service\SecurityService;
use App\Entity\ProfessionLiberale;
use App\Repository\UserRepository;
use App\Repository\LikerRepository;
use Symfony\Component\Mercure\Update;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use App\Repository\ImageProfilRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController {
    /**
     * Permet d'afficher les infos de l'user depuis articles et experience
     * @Route("/show/profil/{id}", name ="user_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
   /*  public function showAuthor(UserRepository $userRepo, ?int $id) {
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
        }

        return $this->render('articles/userShow.html.twig', [ 
            'user' =>$user,
            'type' =>$type
        ]);
    }
 */
    /**
     * Voir tout les articles 
     * @Route("pole/articles", name="articles", methods={"GET", "POST"})
     */
    public function publications(ArticlesRepository $articlesRepository, Request $request, PaginatorInterface $paginator):Response {
        $articles          = $articlesRepository->findAll();
        $articlesPaginator = $paginator->paginate($articles, $request->query->getInt('page', 1),6);

        return $this->render('articles/index.html.twig', [
            'articles' => $articlesPaginator
        ]);
    }

    public function checkPole(?string $pole):bool {
        switch ($pole) {
            case 'Innovation':
                return true;
            break;

            case 'Evolution Des Metiers':
                return true;
            break;

            case 'Evolution Des Savoirs':
                return true;
            break;

            case 'Com Recherche et developpement':
                return true;
            break;

            case 'Immobilier & Silver Experience':
                return true;
            break;

            case 'Universal design & inclusive design':
                return true;
            break;
            
            default:
                return false;
            break;
        }
    }

    /**
     * Nouvel article
     * @Route("pole/new", name="article_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_FONDATEUR') or is_granted('ROLE_ABONNE')")
     */
    public function new(Request $request, EntityManagerInterface $manager):Response {
        $article = new Articles();
 
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            //* get form's data
            $images  = $form->get('images')->getData();
            $imageRE = $form->get('imgArticle')->getData();
            $pole    = $form->get('pole')->getData();

            //* Check if pole name is correct
            if ($this->checkPole($pole) != true) {
                return $this->redirectToRoute('article_new', [
                    'error' => true,
                ]);
            } else {
                $article->setPole($pole);
            }

            //* on genere un nouveau nom de fichier
            if ($imageRE != null) {
                $fichier = md5(uniqid()) . '.' . $imageRE->guessExtension();
                
                //* on copie le fichier dans le dossier uploads/articles
                $imageRE->move(
                    $this->getParameter('article_directory'),
                    $fichier
                );
                
                $img= new Image();
                //* on met le nom du fichier dans ImageRexp
                $img->setImageArt($fichier);
                //* on ajoute l'image au retour Exp correspondant
                $img->setImgArticle($article);
                
                $article->setImgArticle($img);
            }

            $manager->persist($article);
            $manager->flush();

            //* Images de l'articles     
            if ($images != null) {
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
                    
                    $article->addImage($img);
                }
            }

            $article->setAuthor($this->getUser());
            
            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong>{$article->getTitreArticle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('articles', [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifier un article
     * @Route("pole/{slug}/edit", name="article_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user  === article.getAuthor() or is_granted('ROLE_ADMIN')", message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier")
     * @param Articles $article
     * @return Response
     */
    public function edit(Request $request, Articles $article, EntityManagerInterface $manager, ImageProfilRepository $imageRepo):Response {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //* image de profil de l'article
            //* recuperation des images transmises
            $imageRE = $form->get('imgArticle')->getData();

            if($imageRE == null ){
                if($article->getImgArticle() != null){
                    $imageRE = $article->getImgArticle()->getImageArt(); 
                    $fichier = $imageRepo->findOneBy(['imageArt' => $imageRE])->getImageArt(); 
                } else {
                    $fichier = null;
                    $article->setImgArticle(null);
                }
            }else {
                //* on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $imageRE->guessExtension();
                //* on copie le fichier dans le dossier uploads/retourExp
                $imageRE->move(
                    $this->getParameter('article_directory'),
                    $fichier
                );
            }
            
            $image = $imageRepo->FindOneBy(['imgArticle' => $article->getId()]);

            if($image){
                $image->setImageArt($fichier);
            }else{ 
                $img = new Image();
                $image = new $img;
           
                //* on met le nom du fichier dans ImageRexp
                $img->setImageArt($fichier);
                $manager->persist($img);
                $article->setImgArticle($img);
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
                
                $article->addImage($img);
            }

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong>{$article->getTitreArticle()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('article_show', [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->render('articles/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * Supprimer les images
     * @Route("/pole/delete/image/{id}", name="pole_delete_image", methods={"GET","DELETE"})
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

            //* On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * Supprime un article
     * @Route("pole/{slug}/delete", name="article_delete")
     * @Security("is_granted('ROLE_USER') and user  == article.getAuthor()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     * @param Articles $article
     * @return Response
     */
    public function delete(Articles $article, EntityManagerInterface $manager):Response {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'article <strong>{$article->getTitreArticle()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute('articles');
    }

    /**
     * voir un article
     * @Route("pole/{slug}", name="article_show")
     */
    public function article(ArticlesRepository $repoArticle, $slug, Request $request, EntityManagerInterface $manager) {
        $article = $repoArticle->findOneBy(['slug' => $slug]);

        //* Increment number of views 
        $article->setViews($article->getViews() + 1);
        $manager->flush();
        
        $user = $article->getAuthor();
        $type = $user->getType();
        
        //* Formulaire ajout de commentaire
        $comment = new Commentaire();

        $form = $this->createForm(CommentairesType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setArticle($article)
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

        return $this->render('articles/show.html.twig', [
            'form'    => $form->createView(),
            'article' => $article,
            'type'    => $type,
        ]);
    }

    /**
     * permet de filtrer (recherche)
     * @Route("pole/orderBy/{filter}", name="articlesOrderBy")
     */
    public function orderArticlesBy(ArticlesRepository $articlesRepository, Request $request, PaginatorInterface $paginator, String $filter) {
         
        
        if ($filter == 'none') {
            $articles = $articlesRepository->findBy([], ['createdAt' => 'DESC']);
        }else if ($filter == 'latest') {
            $articles = $articlesRepository->findBy([], ['createdAt' => 'DESC']);
        }else if ($filter == 'oldest') {
            $articles = $articlesRepository->findBy([], ['createdAt' => 'ASC']);
        }

        $articlesPaginator = $paginator->paginate($articles, $request->query->getInt('page', 1),6);

        return $this->render('articles/index.html.twig', [
            'articles' => $articlesPaginator
        ]);
    }

    /**
     * @Route("/image/{id}/remove", name="image_remove")
     */ 
    public function removeImg(Image $image,int $id):Response {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($image);
        $entityManager->flush();

        return $this->json([
            'code'    => 200, 
            'message' => 'image bien supprimé',
            'id'      => $id
        ], 200);
    }

    /**
     * @Route("/article/{id}/like", name="article_like")
     * @param Articles $article
     * @param ObjectManager $manager
     * @param ArticlesRepository $ArtRepo
     * @return Response
     */
    public function likeAd(Articles $article, LikerRepository $likeRepo, MessageBusInterface $bus, \Swift_Mailer $mailer ):Response {
        $user    = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        if(!$user) return $this->json([
            'code'    => 403,
            'message' => "Vous devez être connecté"
        ], 403);

        if($article->islikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'article' => $article,
                'user'    => $user
            ]);
            
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code'    => 200,
                'message' => 'Like bien supprimé',
                'isLiked' => false,
                'likes'   => $likeRepo->count(['article' => $article])
            ], 200);
        }

        $like = new Liker();
        $like->setArticle($article)->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code'    => 200, 
            'message' => 'Like bien ajouté',
            'isLiked' => true,
            'likes'   => $likeRepo->count(['article' => $article])
        ], 200);
    }

    /**
     * @Route("pole/searchBar/{keyword}", name="searchToolsArt")
     */
    public function searchTools(ArticlesRepository $articlesRepository, Request $request, String $keyword, PaginatorInterface $paginator) {
        $articlesSearched = [];
        $articles         = $articlesRepository->findAll();
        
        foreach ($articles as $article) {
            $accroche     = strtolower($article->getAccroche());
            $title        = strtolower($article->getTitreArticle());
            $authorNom    = strtolower($article->getAuthor()->getLastName());
            $authorPrenom = strtolower($article->getAuthor()->getFirstName());

            //* Check if the keyword is contain in Title or in Accroche or in author firstname & lastname
            if (preg_match('/' . $title . '/', $keyword)        || str_contains($title, $keyword)     ||
                preg_match('/' . $accroche . '/', $keyword)     || str_contains($accroche, $keyword)  || 
                preg_match('/' . $authorNom . '/', $keyword)    || str_contains($authorNom, $keyword) ||
                preg_match('/' . $authorPrenom . '/', $keyword) || str_contains($authorPrenom, $keyword)) {

                array_push($articlesSearched, $article);
            }
        }

        if (count($articlesSearched) > 0) {
            $articlesPaginator = $paginator->paginate($articlesSearched, $request->query->getInt('page', 1),6);
        } else {
            $articlesPaginator = $paginator->paginate($articles, $request->query->getInt('page', 1),6);
        }

        return $this->render('articles/index.html.twig', [
            'articles' => $articlesPaginator
        ]);
    }

    /**
     * Supprime un commentaire
     * @Route("pole/deleteComm/{id}", name="comm_delete")
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
     * @Route("pole/modifComm/{id}", name="comm_modify")
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
     * like a article
     * @Route("pole/like/{id}", name="likeArt")
     */
    public function likeArticle(Request $request, Articles $article, SecurityService $security):Response {
        try {
            $user = $security->getUser();
            
            $user->addLike($article);
            $article->addUsersLiker($user);
            $article->setLikes($article->getLikes() + 1);

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
     * unlike a article
     * @Route("pole/unlike/{id}", name="unlikeArt")
     */
    public function unlikeArticle(Request $request, Articles $article, SecurityService $security):Response {
        try {
            $user = $security->getUser();
            
            $user->removeLike($article);
            $article->removeUsersLiker($user);
            $article->setLikes($article->getLikes() - 1);

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
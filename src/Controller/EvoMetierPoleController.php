<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/evoMetier")
*/
class EvoMetierPoleController extends AbstractController
{

     /**    accueil */
    /**
     * @Route("/index", name="evo_metier_pole_index")
     */
    public function index(): Response
    {
        return $this->render('poles/evoMetierPole/index.html.twig', [
            'controller_name' => 'EvoMetierPoleController',
        ]);
    }

            /** general ??  */
        /**
     * @Route("/general", name="general_metier")
     */
    public function general(): Response
    {
        return $this->render('poles/evoMetierPole/general.html.twig', [
            'controller_name' => 'EvoMetierPoleController',
           
        ]);
    }


            //**   livres et vidéos conseillés */
            /**
     * @Route("/mediatheque", name="mediatheque_metier")
     */
    public function mdediatheque(): Response
    {
        $medias = 'liste depuis la bdd media';
        $user = $this-> getUser();
        return $this->render('poles/common/mediatheque.html.twig', [
            'medias' => $medias,// liste des livres&videos
            'couleurPole' => 'blue',
            'user' => $user,
        ]);
    }
   
            //**  nouvelles du mois précédent */
        /**
     * @Route("/nouveautes", name="nouveautes")
     */
    public function nouveautes(): Response
    {
        /*************** pour le test temporaire ***********/
        /************************************************** */
        static $text_ex = "Lorem ipsum dolor sit amet. Sit eveniet et commodi ipsum
        vel ducimus
        aperiam!
        Ea dicta aliquam ab iure nisi et vero error aliquam adipisci. Aut blanditiis
        odit et modi totam eos similique enim sit dolor sint aut consectetur
        eligendi et
        rerum consequatur sed galisum quam. Ut unde dolores ut facilis pariatur a
        fugit
        excepturi quo adipisci autem qui facere temporibus est nihil consequatur.

        Eos molestiae odit sit deserunt autem magni sequi. Aut modi voluptas qui
        quos
        unde sit iste voluptatibus. Aut exercitationem ipsam et perferendis odit quo
        consequuntur impedit ea amet rerum et voluptatem exercitationem et
        blanditiis
        eius ut cupiditate velit";
        /******************************************************************** */
        return $this->render('poles/evoMetierPole/nouveautes.html.twig', [
            'text' => $text_ex,        
        ]);
    }


    /*** pour le test récupère les images de poles/metier */
    private function seachDoc($dossier){
        $dir = opendir($dossier) or die('Problème d\'ouverture du dossier.');

    
        while($doc = readdir($dir)) {
            if($doc != '.' && $doc != '..') {
                if(is_dir($dossier.$doc)) {
                    searchDoc($doc);
                } else {
                    //print($dossier.'/'.$doc);
                    $str[] =  '/'.$dossier.'/'.$doc;
                }
            }
        }
        closedir($dir);
     
        return $str;
    }

        //**** photos videos texte en vrac....   */
            /**
     * @Route("/album", name="album")
     */
    public function album(): Response
    {
        /** pour les tests */
      
        $dossier = 'uploads/poles/metier';
        $medias =  $this->seachDoc($dossier);
        /** ********* */

/*         foreach($medias as $val){
            echo '<pre>';
            print_r($val) ;
            echo '</pre>';
        }
        die(); */
        return $this->render('poles/evoMetierPole/album_metier.html.twig', [
            'medias' => $medias,        
        ]);
        
    }    

}

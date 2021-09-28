<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;


/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualiteRepository {
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }


    //Compte les commentaires par article
    public function getCommentsCount($articleId) {
        return $this->manager->createQuery("SELECT COUNT(c) FROM App\Entity\Commentaire c where c.article=$articleId")->getSingleScalarResult();
    }

    //Compte les likes par article
    public function getLikesCount($articleId) {
        return $this->manager->createQuery("SELECT COUNT(l) FROM App\Entity\Liker l where l.article=$articleId")->getSingleScalarResult();
    }

    //Classe les 3 meilleurs articles selon leur notes
    public function getBestArticles($articleId){
        return $this->manager->createQuery("SELECT AVG (c.rating) as note FROM App\Entity\Commentaire c where c.article=$articleId")->getSingleScalarResult();
        // return $this->manager->createQuery("SELECT AVG (c.rating) as note FROM App\Entity\Commentaire c where c.article=$articleId order BY note")->setMaxResults(3)->getResult();
    }

    //Recupère tous les articles
    public function getArticles(){
        return $this->manager->createQuery("SELECT all FROM App\Entity\Articles");
    }

    //Recupère l'article par ID
    public function getArticlesId($articleId){
        return $this->manager->createQuery("SELECT all FROM App\Entity\Articles WHERE id=$articleId");
    }



}
        
    




















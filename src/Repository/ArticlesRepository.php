<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function findBestArticles($limit){
        // a correspond a la table Articles
        return $this->createQueryBuilder('a')
                    // selection les articles et la moyenne AVG des rating de la table commentaire que l'on appele avgRatings
                    ->select('a as articles, AVG(c.rating) as avgRatings')
                    // On join les commentaire de l'articles qu'on appele 
                    ->join('a.commentaire', 'c')
                    // on groupe par articles
                    ->groupBy('a')
                    // ordonne avgRatings 
                    ->orderBy('avgRatings', 'DESC')
                    // on delimite le nombre d'article que l'on veut voir
                    ->setMaxResults($limit)
                    // recupere la requete
                    ->getQuery()
                    // On recupere les resultat grace a getResults
                    ->getResult();
    }

    public function findBestArticlesByPole($pole, $limit){
        // a correspond a la table Articles
        return $this->createQueryBuilder('a')
                    // selection les articles et la moyenne AVG des rating de la table commentaire que l'on appele avgRatings
                    ->select('a as articles, AVG(c.rating) as avgRatings ')
                    // On join les commentaire de l'articles qu'on appele 
                    ->join('a.commentaire', 'c')
                    // on veut recuperer un pole precis
                    ->where('a.pole = :pole')
                    // on groupe par articles
                    ->groupBy('a')
                    // ordonne par date  
                    ->orderBy('avgRatings', 'DESC')
                    // on donne une variable pour recuperer le pole precis
                    ->setParameter('pole', $pole )
                    // on delimite le nombre d'article que l'on veut voir
                    ->setMaxResults($limit)
                    // recupere la requete
                    ->getQuery()
                    // On recupere les resultat grace a getResults
                    ->getResult();
    }

    public function findLastArticles($pole){
        // a correspond a la table Articles
        return $this->createQueryBuilder('a')
                    // selection les articles et la date de creation de la table articles que l'on appele date
                    ->select('a as articles, a.createdAt as date ')
                    // on veut recuperer un pole precis
                    ->where('a.pole = :pole')
                    // on groupe par articles
                    ->groupBy('a')
                    // ordonne par date  
                    ->orderBy('date', 'DESC')
                    // on donne une variable pour recuperer le pole precis
                    ->setParameter('pole', $pole )
                    // on delimite le nombre d'article que l'on veut voir
                    ->setMaxResults(1)
                    // recupere la requete
                    ->getQuery()
                    // On recupere les resultat grace a getResults
                    ->getResult();
    }

    // /**
    //  * @return Articles[] Returns an array of Articles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\RetourExp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RetourExp|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetourExp|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetourExp[]    findAll()
 * @method RetourExp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetourExpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetourExp::class);
    }

    public function findBestRetourExp($limit){
        // a correspond a la table RetourExp
        return $this->createQueryBuilder('re')
                    // selection les retourExp et la moyenne AVG des rating de la table commentaire que l'on appele avgRatings
                    ->select('re as RetourExp, AVG(c.rating) as avgRatings')
                    // On join les commentaire du retourExp qu'on appele 
                    ->join('re.commentaire', 'c')
                    // on groupe par retourExp
                    ->groupBy('re')
                    // ordonne avgRatings 
                    ->orderBy('avgRatings', 'DESC')
                    // on delimite le nombre de retourExp que l'on veut voir
                    ->setMaxResults($limit)
                    // recupere la requete
                    ->getQuery()
                    // On recupere les resultat grace a getResults
                    ->getResult();
    }

    public function findLastRetourExp(){
        // a correspond a la table RetourExp
        return $this->createQueryBuilder('re')
                    // selection les articles et la date de creation de la table articles que l'on appele date
                    ->select('re as RetourExp, re.createdAt as date ')
                    // on groupe par articles
                    ->groupBy('re')
                    // ordonne par date  
                    ->orderBy('date', 'DESC')
                    // on delimite le nombre d'article que l'on veut voir
                    ->setMaxResults(3)
                    // recupere la requete
                    ->getQuery()
                    // On recupere les resultat grace a getResults
                    ->getResult();
    }

    // /**
    //  * @return RetourExp[] Returns an array of RetourExp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RetourExp
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

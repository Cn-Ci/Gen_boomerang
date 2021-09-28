<?php

namespace App\Repository;

use App\Entity\Retraite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Retraite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retraite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retraite[]    findAll()
 * @method Retraite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetraiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retraite::class);
    }

    // /**
    //  * @return Retraite[] Returns an array of Retraite objects
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
    public function findOneBySomeField($value): ?Retraite
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

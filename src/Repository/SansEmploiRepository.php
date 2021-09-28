<?php

namespace App\Repository;

use App\Entity\SansEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SansEmploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method SansEmploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method SansEmploi[]    findAll()
 * @method SansEmploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SansEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SansEmploi::class);
    }

    // /**
    //  * @return SansEmploi[] Returns an array of SansEmploi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SansEmploi
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

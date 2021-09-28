<?php

namespace App\Repository;

use App\Entity\SecteurActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecteurActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecteurActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecteurActivite[]    findAll()
 * @method SecteurActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteurActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecteurActivite::class);
    }

    // /**
    //  * @return SecteurActivite[] Returns an array of SecteurActivite objects
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
    public function findOneBySomeField($value): ?SecteurActivite
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

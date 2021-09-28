<?php

namespace App\Repository;

use App\Entity\Entrepreneur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entrepreneur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrepreneur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrepreneur[]    findAll()
 * @method Entrepreneur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepreneurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrepreneur::class);
    }

    // /**
    //  * @return Entrepreneur[] Returns an array of Entrepreneur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entrepreneur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\ProfessionLiberale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfessionLiberal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfessionLiberal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfessionLiberal[]    findAll()
 * @method ProfessionLiberal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionLiberaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfessionLiberale::class);
    }

    // /**
    //  * @return ProfessionLiberal[] Returns an array of ProfessionLiberal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfessionLiberal
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

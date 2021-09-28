<?php

namespace App\Repository;

use App\Entity\FaQuestions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FaQuestions|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaQuestions|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaQuestions[]    findAll()
 * @method FaQuestions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaQuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaQuestions::class);
    }

    // /**
    //  * @return FaQuestions[] Returns an array of FaQuestions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FaQuestions
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

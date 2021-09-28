<?php

namespace App\Repository;

use App\Entity\NewsletterNotConnected;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterNotConnected|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterNotConnected|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterNotConnected[]    findAll()
 * @method NewsletterNotConnected[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterNotConnectedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterNotConnected::class);
    }

    // /**
    //  * @return NewsletterNotConnected[] Returns an array of NewsletterNotConnected objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsletterNotConnected
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

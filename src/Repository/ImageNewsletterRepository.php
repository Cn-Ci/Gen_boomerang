<?php

namespace App\Repository;

use App\Entity\ImageNewsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageNewsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageNewsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageNewsletter[]    findAll()
 * @method ImageNewsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageNewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageNewsletter::class);
    }

    // /**
    //  * @return ImageNewsletter[] Returns an array of ImageNewsletter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageNewsletter
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

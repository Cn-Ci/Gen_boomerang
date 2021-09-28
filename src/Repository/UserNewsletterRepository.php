<?php

namespace App\Repository;

use App\Entity\UserNewsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserNewsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserNewsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserNewsletter[]    findAll()
 * @method UserNewsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserNewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserNewsletter::class);
    }


    public function findByPoleId($poleId, $userEmail){
        return $this->createQueryBuilder('u')
        ->select('p.id')
        ->innerJoin('u.poles', 'p')
        ->where('p.id = :pole_id')
        ->andWhere('u.email = :user_email')
        ->setParameter('pole_id', $poleId)
        ->setParameter('user_email', $userEmail)
        ->getQuery()->getResult();
        
/*      

        createQueryBuilder('n')
            ->select('a', 'u')
            ->from('AppBundle:UserNewsletter', 'u')
            ->innerJoin('u.associations', 'ua')
            ->andWhere('u.poles in : val') */
           /* ->andWhere('n.poles in :val')
           ->setParameter('val',$poleId)
           ->setMaxResults(1)
           ->getQuery()
           ->getResult() */
           ;

    }
    // /**
    //  * @return UserNewsletter[] Returns an array of UserNewsletter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserNewsletter
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

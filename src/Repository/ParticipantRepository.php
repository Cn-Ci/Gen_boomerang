<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Participant::class);
    }

    /**
     * @return Integer Returns an int to check if conversation belongs to user
     */
    public function checkBelongs($conversationId , $userId) {
        $qb = $this->createQueryBuilder('p');
        return $qb
            ->select('count(p.id)')
            ->where('p.user = :userId')
            ->andWhere('p.conversation = :conversationId')
            ->setParameter('userId' , $userId)
            ->setParameter('conversationId' , $conversationId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
    //  */
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('c.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    
    /*
    public function findOneBySomeField($value): ?Participant
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

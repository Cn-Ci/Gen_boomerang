<?php

namespace App\Repository;

use App\Entity\Participant;
use App\Entity\Conversation;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Conversation::class);
    }

    /*
    * @return Conversation[] Returns an array of Conversation objects
    */  
    public function findUserConversations($userId) {
        // Retrouver les conversations auquelles le user a participé
        // $sql = ('SELECT * FROM conversation c INNER JOIN participant p ON c.id = p.conversation_id WHERE p.user_id = ?');
        
        return $this->createQueryBuilder('c')
            ->innerJoin('c.participants' , 'p' , Expr\Join::WITH)
            ->where('p.user = :userId')
            ->setParameter('userId' , $userId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Integer Return an integer to test if User is present in Conversation
     */
    public function checkBelongs($conversationId , $userId):?Integer {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $conversationId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /*
    public function findOneBySomeField($value): ?Conversation
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

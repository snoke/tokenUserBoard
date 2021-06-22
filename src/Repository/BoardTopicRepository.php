<?php

namespace App\Repository;

use App\Entity\BoardTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardTopic[]    findAll()
 * @method BoardTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardTopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardTopic::class);
    }

    // /**
    //  * @return BoardTopic[] Returns an array of BoardTopic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoardTopic
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

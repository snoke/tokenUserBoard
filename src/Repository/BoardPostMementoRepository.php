<?php

namespace App\Repository;

use App\Entity\BoardPostMemento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardPostMemento|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardPostMemento|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardPostMemento[]    findAll()
 * @method BoardPostMemento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardPostMementoMementoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardPostMemento::class);
    }

    // /**
    //  * @return BoardPostMemento[] Returns an array of BoardPostMemento objects
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
    public function findOneBySomeField($value): ?BoardPostMemento
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

<?php

namespace App\Repository;

use App\Entity\BoardCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardCategory[]    findAll()
 * @method BoardCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardCategory::class);
    }

    // /**
    //  * @return BoardCategory[] Returns an array of BoardCategory objects
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
    public function findOneBySomeField($value): ?BoardCategory
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

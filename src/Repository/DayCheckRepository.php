<?php

namespace App\Repository;

use App\Entity\DayCheck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DayCheck|null find($id, $lockMode = null, $lockVersion = null)
 * @method DayCheck|null findOneBy(array $criteria, array $orderBy = null)
 * @method DayCheck[]    findAll()
 * @method DayCheck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DayCheckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DayCheck::class);
    }

    // /**
    //  * @return DayCheck[] Returns an array of DayCheck objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DayCheck
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Hearth;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hearth|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hearth|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hearth[]    findAll()
 * @method Hearth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HearthRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hearth::class);
    }



    // /**
    //  * @return Hearth[] Returns an array of Hearth objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hearth
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

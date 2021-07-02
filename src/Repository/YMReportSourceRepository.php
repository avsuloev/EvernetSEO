<?php

namespace App\Repository;

use App\Entity\YMReportSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YMReportSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method YMReportSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method YMReportSource[]    findAll()
 * @method YMReportSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YMReportSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YMReportSource::class);
    }

    // /**
    //  * @return YMReportSource[] Returns an array of YMReportSource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?YMReportSource
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

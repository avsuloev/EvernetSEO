<?php

namespace App\Repository;

use App\Entity\YMReportVisits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YMReportVisits|null find($id, $lockMode = null, $lockVersion = null)
 * @method YMReportVisits|null findOneBy(array $criteria, array $orderBy = null)
 * @method YMReportVisits[]    findAll()
 * @method YMReportVisits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YMReportVisitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YMReportVisits::class);
    }

    // /**
    //  * @return YMReportVisits[] Returns an array of YMReportVisits objects
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
    public function findOneBySomeField($value): ?YMReportVisits
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
